<?php

/**
 * Main Controller module
 */

namespace App\Controller\Adventure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

// ADVENTURE
use App\Adventure\RoomHandler;
use App\Adventure\Room;
use App\Adventure\Human;
use App\Adventure\Dragon;
use App\Adventure\Weapon;
use App\Adventure\Food;
use App\Adventure\BackPack;

class TwigAdventure extends AbstractController
{
    #[Route("/adventure/graveyard", name:"graveyard")]
    public function graveyard(Session $session) {
        $roomHandler = $session->get("roomHandler"); // måste starta session

        $graveyard = $roomHandler->getRoomByName("graveyard");

        $data = [
            "rooms" => $roomHandler->getAllRooms(),
            "img" => $graveyard->getImg(),
            "items" => $graveyard->getItems(),
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
}