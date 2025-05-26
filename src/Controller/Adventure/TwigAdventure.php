<?php

/**
 * Main Controller module
 */

namespace App\Controller\Adventure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Controller\Adventure\JsonAdventure;
use Symfony\Component\HttpFoundation\Request;

// ADVENTURE
use App\Controller\Adventure\SesssionHandler;
use App\Adventure\RoomHandler;
use App\Adventure\Room;
use App\Adventure\Human;
use App\Adventure\Dragon;
use App\Adventure\Weapon;
use App\Adventure\Food;
use App\Adventure\BackPack;

class TwigAdventure extends AbstractController
{   
    #[Route("/adventure/init", name:"init_adventure")]
    public function init(SessionHandler $sessionHandler) {
        $sessionHandler->initAdventure();

        return $this->redirectToRoute("graveyard");
    }


    #[Route("/adventure/graveyard", name:"graveyard")]
    public function graveyard(Session $session) {
        $roomHandler = $session->get("roomHandler");
        $human = $session->get("human");

        $graveyard = $roomHandler->getRoomByName("graveyard");
        $data = [
            "backpack" => array_map(fn($item) => $item->getName(), $human->getItemsInBag()),
            "img" => $graveyard->getImg(),
            "roomObjects" => $graveyard->getItems(),
            "next" => $roomHandler->getNextRoom("graveyard")->getName()
        ];
        
        return $this->render("adventure/graveyard.html.twig", $data);
    }


    #[Route("/adventure/house", name:"house")]
    public function house(Session $session) {
        $roomHandler = $session->get("roomHandler"); // måste starta session

        $graveyard = $roomHandler->getRoomByName("house");

        $data = [
            "rooms" => $roomHandler->getAllRooms(),
            "img" => $graveyard->getImg(),
            "items" => $graveyard->getItems(),
            "next" => $roomHandler->getNextRoom("house")->getName()
        ];
        
        return $this->render("adventure/graveyard.html.twig", $data);
    }


    #[Route("/adventure/apple", name:"apple")]
    public function apple(Session $session) {
        $roomHandler = $session->get("roomHandler"); // måste starta session

        $graveyard = $roomHandler->getRoomByName("apple");

        $data = [
            "rooms" => $roomHandler->getAllRooms(),
            "img" => $graveyard->getImg(),
            "items" => $graveyard->getItems(),
            "next" => $roomHandler->getNextRoom("apple")->getName()
        ];
        
        return $this->render("adventure/graveyard.html.twig", $data);
    }


    #[Route("/adventure/dragon", name:"dragon")]
    public function dragon(Session $session) {
        $roomHandler = $session->get("roomHandler"); // måste starta session

        $graveyard = $roomHandler->getRoomByName("dragon");

        $data = [
            "rooms" => $roomHandler->getAllRooms(),
            "img" => $graveyard->getImg(),
            "items" => $graveyard->getItems(),
            "next" => $roomHandler->getNextRoom("dragon")->getName()
        ];
        
        return $this->render("adventure/graveyard.html.twig", $data);
    }


    #[Route("/adventure/win", name:"win")]
    public function win(Session $session) {
        $roomHandler = $session->get("roomHandler"); // måste starta session

        $graveyard = $roomHandler->getRoomByName("win");

        $data = [
            "rooms" => $roomHandler->getAllRooms(),
            "img" => $graveyard->getImg(),
            "items" => $graveyard->getItems(),
        ];
        
        return $this->render("adventure/win.html.twig", $data);
    }

    #[Route("/adventure/item", name:"equip_item", methods:["POST"])]
    public function equipItem(Request $request)
    {
        // fetch item
        $item = $request->request->all()["item"] ?? null;

        // add to humans backpack
        $session = $request->getSession();
        
        $human = $session->get("human") ?? "Human finns inte";

        if ($item === "Apple"){
            $human->addItemToBackPack(new Food($item, 50));
        } $human->addItemToBackPack(new Weapon($item, 100));
        
        $this->addFlash("notice", "You equipped the $item");
        // return $this->json($item);
        return $this->redirectToRoute('graveyard');
    }
}