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
use App\Adventure\DialogHandler;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Room as dbRoom;
use App\Entity\Tool as dbTool;
use App\Entity\Weapon as dbWeapon;

class SessionHandler
{
    /**
     * @var RequestStack $requestStack
     */
    private $requestStack;
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
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
        if (!$this->initRoomsDb()) {
            $this->initRooms($session);
        };
        $this->initItemsDb();
        $this->initHuman($session);
        $this->initDragon($session);
        $this->initDialog($session);
    }

    /**
     * Initiate the dialog
     * Save dialogHandler in session
     * @return void
     */
    public function initDialog($session): void
    {
        $session->set("dialogHandler", new DialogHandler());
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
     * Create room objects based on rooms in database
     * If there are no rooms in database, room objects cannot be created
     * therefore returns false, else true
     * @return bool wheter it was created or not
     */
    public function initRoomsDb(): bool
    {
        $session = $session = $this->requestStack->getSession();
        $rooms = $this->entityManager->getRepository(dbRoom::class)->findAll();

        $roomHandler = new RoomHandler();
        if (!$rooms) {
            return false;
        } foreach ($rooms as $room) {
            $newRoom = new Room($room->getName());
            $newRoom->setImg($room->getBackground());
            $roomHandler->addRoom($newRoom);
        }
        $session->set("roomHandler", $roomHandler);
        return true;
    }


    /**
     * Create item objects in rooms based on items and rooms in database
     *
     */
    public function initItemsDb(): void
    {
        $session = $session = $this->requestStack->getSession();
        $roomHandler = $session->get("roomHandler");
        $graveyard = $roomHandler->getRoombyName("graveyard");

        $items = $this->entityManager->getRepository(dbTool::class)->findAll();
        $weapon = $this->entityManager->getRepository(dbWeapon::class)->findWeaponByName("Sword");

        foreach ($items as $item) {
            $newItem = new Item($item->getName(), $item->getIcon());
            $graveyard->addItem($newItem);
        }

        $newWeapon = new Weapon($weapon->getName(), $weapon->getDmg(), $weapon->getIcon());
        $graveyard->addItem($newWeapon);

        $session->set("roomHandler", $roomHandler);
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
            ],
            "apple" => [
                "title" => "apple",
            ],
            "dragon" => [
                "title" => "dragon",
            ]
        ];

        $roomHandler = new RoomHandler();

        foreach ($roomData as $data) {
            $room = new Room($data["title"]);
            $room->setImg($data["title"] . ".png");
            if (array_key_exists("items", $data)) {
                foreach ($data["items"] as $item) {
                    $room->addItem(new Item($item["name"], $item["icon"]));
                }
            }

            if (array_key_exists("weapons", $data)) {
                foreach ($data["weapons"] as $weapon) {
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
    public function resetSession()
    {
        $this->initAdventure();
    }
}
