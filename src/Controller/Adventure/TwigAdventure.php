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

    #[Route("/adventure/init", name:"init_adventure")]
    public function init(SessionHandler $sessionHandler) {
        
        // Get data for current room
        $sessionHandler->initAdventure();
        return $this->redirectToRoute("graveyard");
    }


    #[Route("/adventure/graveyard", name:"graveyard")]
    public function graveyard(Session $session)
    {    
        // Get data for current room
        $data = $this->getDataByRoom($session, "graveyard");
        return $this->render("adventure/graveyard.html.twig", $data);
    }


    #[Route("/adventure/house", name:"house")]
    public function house(Session $session) {

        // Get data for current room
        $data = $this->getDataByRoom($session, "house");
        return $this->render("adventure/house.html.twig", $data);
    }


    #[Route("/adventure/apple", name:"apple")]
    public function apple(Session $session) {
    
        // Get data for current room
        $data = $this->getDataByRoom($session, "apple");
        return $this->render("adventure/apple.html.twig", $data);
    }


    #[Route("/adventure/dragon", name:"dragon")]
    public function dragon(Session $session) {

        // Get data for current room
        $data = $this->getDataByRoom($session, "dragon");
        return $this->render("adventure/dragon.html.twig", $data);
    }


    #[Route("/adventure/win", name:"win")]
    public function win(Session $session) {
    
        // Get data for current room
        $data = $this->getDataByRoom($session, "win");    
            return $this->render("adventure/win.html.twig", $data);
    }

    #[Route("/adventure/lost", name:"lost")]
    public function lost(Session $session) {
    
        // Get data for current room
        $data = $this->getDataByRoom($session, "lost");    
            return $this->render("adventure/lost.html.twig", $data);
    }

    #[Route("/adventure/item", name:"equip_item", methods:["POST"])]
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

    #[Route("/adventure/action", name:"use_item", methods:["POST"])]
    public function useItem(Request $request) {
        $posted = $request->request->all();
        $route = $posted["referer_route"];
        $action = $posted["action"] ?? null;
        
        if ($action === "dig") {
            $ItemObj = new Item("key", "key.png");
            $session = $request->getSession();
            $roomHandler = $session->get("roomHandler");
            $roomHandler->addItemToRoom("graveyard", $ItemObj);
        }
        return $this->redirectToRoute($route);
    }
}