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
     * To add more rooms, just add another object
     * IMG has to be an existing asset
     * 
     * @return void
     */
    private function initRooms(Session $session): void
    {   
        $roomData = [
            "graveyard" => [
                "title" => "graveyard",
                "items" => [
                    ["name" => "shovel",
                    "icon" => "shovel.png"],
                    ["name" => "coin",
                    "icon" => "coin.png"],
                    ["name" => "tooth",
                    "icon" => "tooth.png"]
                ],
                "weapons" => [
                    [
                        "name" => "sword", 
                        "dmg" => 100,
                        "icon" => "sword.png"]]
            ],
            "house" => [
                "title" => "house",
                "items" => [
                    ["name" => "skull", "icon" => "skull.png"]
                ],
                "weapons" => [
                    [
                        "name" => "axe",
                        "dmg" => 55,
                        "icon" => "axe.png"
                    ]
                ]
            ],
            "apple" => [
                "title" => "apple",
                "items" => [
                    ["name" => "Apple", "icon" => "apple.png"],
                    ["name" => "note", "icon" => "note.png"]
                ],
                "weapons" => [
                    [
                        "name" => "knife",
                        "dmg" => 10,
                        "icon" => "knife.png"
                    ]
                ]
            ],
            "dragon" => [
                "title" => "dragon",
                "items" => [
                    ["name" => "treassure", "icon" => "treassure.png"],
                    ["name" => "human remains", "icon" => "humanremains.png"]
                ],
                "weapons" => [
                    [
                        "name" => "Sharp bone",
                        "dmg" => 10,
                        "icon" => "bone.png"
                    ]
                ]
            ]
        ];
        
        $roomHandler = new RoomHandler();

        foreach($roomData as $data) {
            $room = new Room($data["title"]);
            $room->setImg($data["title"] . ".png");
            foreach($data["items"] as $item) {
                $room->addItem(new Item($item["name"], $item["icon"]));
            }
            if ($data["weapons"]) {
                foreach($data["weapons"] as $weapon) {
                    $room->addItem(new Weapon($weapon["name"], (int) $weapon["dmg"], $weapon["icon"]));
                }
            }
            $roomHandler->addRoom($room);
        }
        $session->set("roomHandler", $roomHandler);
    }

    /**
     * Reset session variables
     */
    public function resetSession() {
        $this->initAdventure();
    }
}