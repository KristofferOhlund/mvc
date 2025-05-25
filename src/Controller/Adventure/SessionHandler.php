<?php

namespace App\Controller\Adventure;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Adventure\Human;
use App\Adventure\Dragon;
use App\Adventure\RoomHandler;
use App\Adventure\Room;
use App\Adventure\Weapon;
use App\Adventure\Food;
use App\Adventure\BackPack;

class SessionHandler
{   
    /**
     * @var RequestStack $requestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Main method for adventure
     * Call private methods for setting upp the rooms, player and dragon
     * 
     * @return void
     */
    public function initAdventure(): void
    {
        $session = $this->requestStack->getSession();
        
        // Initiate all game session variables
        $this->initHuman($session);
        $this->initDragon($session);
        $this->initRooms($session);
    }

    /**
     * Initiate the human
     * 
     * @return void
     */
    private function initHuman(Session $session): void
    {   
        $human = new Human("DragonSlayer");
        $backpack = new BackPack();
        $human->equipBackPack($backpack);
        $session->set("human", $human);
    }

    /**
     * Initiate the dragon
     * 
     * @return void
     */
    private function initDragon(Session $session): void
    {
        $session->set("dragon", new Dragon("DeathWing"));
    }

    /**
     * Create rooms
     * Each room has its own set of items and background image
     * 
     * @return void
     */
    private function initRooms(Session $session): void
    {   
        $rooms = ["graveyard", "house", "apple", "dragon", "win"];
        $roomHandler = new RoomHandler();
        for ($i = 0; $i < count($rooms); $i++)
        {
            $room = new Room($rooms[$i]);
            $room->setImg($rooms[$i] . ".png");
            $food = new Food("Apple", 100);
            $weapon = new Weapon("Sword", 100);
            $room->addItem($food);
            $room->addItem($weapon);
            $roomHandler->addRoom($room);
        }
        $session->set("roomHandler", $roomHandler);
    }
}