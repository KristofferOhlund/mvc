<?php

/**
 * JSON Controllers
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

class JsonAdventure extends AbstractController
{
    /**
     * Create all rooms and assets
     * @return RoomHandler
     */
    private function roomsInit(): RoomHandler {
        $roomImages = ["graveyard", "house", "apple", "dragon", "win"];
        $roomHandler = new RoomHandler();
        for ($i = 0; $i < count($roomImages); $i++)
        {
            $room = new Room($roomImages[$i]);
            $room->setImg($roomImages[$i] . ".png");
            $food = new Food("Apple", 100);
            $weapon = new Weapon("Sword", 100);
            $room->addItem($food);
            $room->addItem($weapon);
            $roomHandler->addRoom($room);
        }
        // $session->set("roomHandler", $roomHandler);
        return $roomHandler;
    }

    /**
     * Create a new player object
     * @return Human
     */
    private function playerInit(): Human {
        $player = new Human("Player");
        $backpack = new BackPack();
        $player->equipBackPack($backpack);
        return $player;
    }

    /**
     * Create a new dragon object
     * @return Dragon
     */
    private function dragonInit(): Dragon {
        return new Dragon("DeathWing");
    }

    /**
     * Initiate the game
     */
    #[Route("/jsonadventure/init", name:"init_adventure")]
    public function initAdventure(Session $session): Response
    {   
        // Create a room handler
        $roomHandler = $this->roomsInit();
        $player = $this->playerInit();
        $dragon = $this->dragonInit();

        $data = [
            "rooms" => $roomHandler->getAllRooms(),
            "human" => $player->getName(),
            "dragon" => $dragon->getName()
        ];

        $response = $this->json($data);
        $response->setEncodingOptions($response->getEncodingOptions() || JSON_PRETTY_PRINT);

        $session->set("roomHandler", $roomHandler);
        return $response;
    }

    /**
     * First route
     */
    #[Route("/jsonadventure/graveyard", name:"graveyard")]
    public function graveyard(Session $session): Response
    {   
        $roomHandler = $session->get("roomHandler");
        $graveyard = $roomHandler->getRoomByName("graveyard");
        return $this->json($graveyard)?->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    /**
     * Reset current session
     */
    #[Route("/jsonadventure/reset", name:"reset")]
    public function reset(Session $session): Response
    {   
        $session->set("roomHandler", null);
        $roomHandler = $session->get("roomHandler");
        
        $response = $this->json($roomHandler);
        return $response->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
