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
use App\Adventure\Item;
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
        $roomData = [
            "graveyard" => [
                "title" => "graveyard",
                "items" => ["Shovel", "Gold coin", "Tooth"],
                "weapons" => [
                    [
                        "name" => "sword", 
                        "dmg" => 100]]
            ],
            "house" => [
                "title" => "house",
                "items" => ["Shovel", "Gold coin", "Tooth"],
                "weapons" => [
                    [
                        "name" => "axe", 
                        "dmg" => 55]
                    ]
            ],
            "apple" => [
                "title" => "apple",
                "items" => ["Shield", "glasses", "mysterious note"],
                "weapons" => [
                    [
                        "name" => "knife", 
                        "dmg" => 10]
                    ]
            ],
            "dragon" => [
                "title" => "dragon",
                "items" => ["treassure", "bones", "Tooth"],
                "weapons" => null
            ]
            ];
        
        $roomHandler = new RoomHandler();

        foreach($roomData as $data) {
            $room = new Room($data["title"]);
            $room->setImg($data["title"] . ".png");
            foreach($data["items"] as $item) {
                $room->addItem(new Item($item));
            }
            if ($data["weapons"]) {
                foreach($data["weapons"] as $weapon) {
                    $room->addItem(new Weapon($weapon["name"], (int) $weapon["dmg"]));
                }
            }
            
            $roomHandler->addRoom($room);
        }
        // $rooms = [
        //     "graveyard", 
        //     "house", 
        //     "apple", 
        //     "dragon", 
        //     "win"];
        // $roomHandler = new RoomHandler();
        // for ($i = 0; $i < count($rooms); $i++)
        // {
        //     $room = new Room($rooms[$i]);
        //     $room->setImg($rooms[$i] . ".png");
        //     $roomHandler->addRoom($room);
        // }
        $session->set("roomHandler", $roomHandler);
    }

    /**
     * Reset session variables
     */
    public function resetSession() {
        $this->initAdventure();
    }
}