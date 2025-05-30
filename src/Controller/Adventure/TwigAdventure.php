<?php

/**
 * Main Controller module
 */

namespace App\Controller\Adventure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

// ADVENTURE
use App\Adventure\Weapon;
use App\Adventure\Food;
use App\Adventure\Item;

class TwigAdventure extends AbstractController
{   
    
    /**
     * Some data variables are the same for each route
     * Use method to get basic data and extend data in route
     * Returns roomObjects stored in room
     * @param Session $session - current session
     * @param string $roomName - the current room  
     * @return array
     */
    private function getDataByRoom(Session $session, string $roomName): array {
        $roomHandler = $session->get("roomHandler");

        
        $human = $session->get("human");
        $dragon = $session->get("dragon");
        $validRooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        if (!in_array($roomName, $validRooms)) {
            throw new \Exception("Room $roomName is not a valid room");
        }

        $room = $roomHandler->getRoomByName($roomName);
        $data = [
            "human" => $human,
            "dragon" => $dragon,
            "backpack" => array_map(fn($item) => $item->getName(), $human->getItemsInBag()), // get all item names in bg
            "img" => $room->getImg(),
            "room" => $room,
            "roomObjects" => $room->getItems(),
            "next" => $roomHandler->getNext($roomName),
            "prev" => $roomHandler->getPrev($roomName)
        ];

        return $data;
    }

    #[Route("/proj/init", name:"init_adventure")]
    public function init(SessionHandler $sessionHandler) {
        
        // Get data for current room
        $sessionHandler->initAdventure();
        return $this->redirectToRoute("graveyard");
    }


    #[Route("/proj/graveyard", name:"graveyard")]
    public function graveyard(Session $session)
    {    
        // Get data for current room
        $data = $this->getDataByRoom($session, "graveyard");
        return $this->render("adventure/graveyard.html.twig", $data);
    }


    #[Route("/proj/house", name:"house")]
    public function house(Session $session) {

        // Get data for current room
        $data = $this->getDataByRoom($session, "house");
        return $this->render("adventure/house.html.twig", $data);
    }


    #[Route("/proj/apple", name:"apple")]
    public function apple(Session $session) {
    
        // Get data for current room
        $data = $this->getDataByRoom($session, "apple");
        return $this->render("adventure/apple.html.twig", $data);
    }


    #[Route("/proj/dragon", name:"dragon")]
    public function dragon(Session $session) {

        // Get data for current room
        $data = $this->getDataByRoom($session, "dragon");
        return $this->render("adventure/dragon.html.twig", $data);
    }


    #[Route("/proj/win", name:"win")]
    public function win(Session $session) {
    
        // Get data for current room
        // $data = $this->getDataByRoom($session, "win");
        return $this->render("adventure/win.html.twig");
    }

    #[Route("/proj/lost", name:"lost")]
    public function lost(Session $session) {
    
        // Get data for current room
        return $this->render("adventure/lost.html.twig");
    }

    #[Route("/proj/item", name:"equip_item", methods:["POST"])]
    public function equipItem(Request $request)
    {
        // fetch item
        $posted = $request->request->all();
        $route = $posted["referer_route"];
        $item = $posted["item"] ?? null;

        // redirect if equip is pressed without a selected option
        if (!$item) {
            return $this->redirectToRoute($route);
        }

        $icon = $item . ".png";
        
        // add to humans backpack
        $session = $request->getSession();
        $human = $session->get("human") ?? "Human finns inte";

        
        if ($item === "Apple"){
            $human->addItemToBackPack(new Food($item, 50, $icon));
        } else if ($item !== "Sword") {
            $human->addItemToBackPack(new Item($item, $icon));
        } if ($item === "Sword") {
            $human->addWeapon(new Weapon($item, 100, $icon));
        }
        
        $this->addFlash("notice", "You equipped the $item with icon $icon");
        return $this->redirectToRoute($route);
    }

    #[Route("/proj/action", name:"use_item", methods:["POST"])]
    public function useItem(Request $request) {
        $posted = $request->request->all();
        $route = $posted["referer_route"];
        $action = $posted["action"] ?? null;
        
        if ($action === "dig") {
            $ItemObj = new Item("key", "key.png");

        } if ($action === "unlock") {
            $ItemObj = new Item("apple", "apple.png");
            $route = "apple";
        }

        $session = $request->getSession();
        $roomHandler = $session->get("roomHandler");
        $roomHandler->addItemToRoom($route, $ItemObj);
        return $this->redirectToRoute($route);
    }

    #[Route("/proj/attack", name:"attack", methods:["POST"])]
    public function attack(Request $request)
    {
        $session = $request->getSession();
        $human = $session->get("human");
        $dmg = $human->attackWithWeapon();

        $this->addFlash("notice", "You strike the dragon with your weapon, dealing $dmg dmg");
        
        $dragon = $session->get("dragon");
        $dragon->reduceHealth((int) $dmg);

        if ($dragon->getHealth() < 0) {
            return $this->redirectToRoute("win");
        }

        $dragonDmg = $dragon->sprayFire();
        $human->reduceHealth((int) $dragonDmg);

        $this->addFlash("notice", "The dragon roars and draws his breath, filling the entire room with fire");

        if ($human->getHealth() < 0) {
            return $this->redirectToRoute("lost");
        } 

        return $this->redirectToRoute("dragon");

    }
    #[Route("/proj/eat", name:"eat", methods:["POST"])]
    public function eat(Request $request)
    {
        $session = $request->getSession();
        $human = $session->get("human");
        $human->eatFood($human->getItemByName("Apple"));
        return $this->redirectToRoute("dragon");
    }
}