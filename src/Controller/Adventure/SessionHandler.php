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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionHandler
{
    /**
     * @var RequestStack $requestStack
     */
    private $requestStack;
    /**
     * @var EntityManagerInterface $entityManager
     */
    private EntityManagerInterface $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    /**
     * Main method for adventure
     * Call private methods for setting upp the rooms, player and dragon
     * All lootable weapons and items are added in the Graveyard room
     *
     * @return void
     */
    public function initAdventure(): void
    {
        $session = $this->requestStack->getSession();
        $rooms = $this->entityManager->getRepository(dbRoom::class)->findAll();
        if (!$rooms) {
            $rooms = $this->createDbRooms();
        }
        $this->initDbRooms($rooms);

        $weapons = $this->entityManager->getRepository(dbWeapon::class)->findAll();
        if (!$weapons) {
            $weapons = $this->createDbWeapons();
        }
        $this->initDbWeapons($weapons);

        $items = $this->entityManager->getRepository(dbTool::class)->findAll();
        if (!$items) {
            $items = $this->createDbItems();
        }
        $this->initDbItems($items);
        
        $this->initHuman($session);
        $this->initDragon($session);
        $this->initDialog($session);
    }


    /**
     * Create rooms in db, return list of rooms
     * @return array<int, object>
     */
    private function createDbRooms(): array
    {   
        $create = ["graveyard", "house", "apple", "dragon"];
        foreach($create as $room) {
            $newRoom = new dbRoom();
            $newRoom->setName($room);
            $newRoom->setBackground($room . ".png");
            $this->entityManager->persist($newRoom);
            $this->entityManager->flush();
        }

        return $this->entityManager->getRepository(dbRoom::class)->findAll();
    }

    /**
     * Create room objects based on rooms in database
     * If there are no rooms in database, create rooms.
     * Then create objects based on those rooms
     * @param array<int, object> $rooms
     * @return string msg
     */
    private function initDbRooms($rooms): string
    {
        $session = $session = $this->requestStack->getSession();
        // $rooms = $this->entityManager->getRepository(dbRoom::class)->findAll();

        $roomHandler = new RoomHandler();

        foreach ($rooms as $room) {
            $newRoom = new Room($room->getName());
            $newRoom->setImg($room->getBackground());
            $roomHandler->addRoom($newRoom);
        }
        $session->set("roomHandler", $roomHandler);
        return "room objects created from database";
    }

    /**
     * Create weapons in db, return list of rooms
     * @return array<int, object>
     */
    private function createDbWeapons(): array
    {   
        $create = ["Sword"];
        foreach($create as $weapon) {
            $newWeapon = new dbWeapon();
            $newWeapon->setName($weapon);
            $newWeapon->setIcon($weapon . ".png");
            $newWeapon->setDmg(100);
            $this->entityManager->persist($newWeapon);
            $this->entityManager->flush();
        }

        return $this->entityManager->getRepository(dbWeapon::class)->findAll();
    }


    /**
     * Create weapon objects in Graveyard
     * @return string msg
     *
     */
    private function initDbWeapons($weapons): string
    {
        $session = $session = $this->requestStack->getSession();
        $roomHandler = $session->get("roomHandler");
        $graveyard = $roomHandler->getRoombyName("graveyard");

        foreach ($weapons as $weapon) {
            $newWeapon = new Weapon($weapon->getName(), $weapon->getDmg(), $weapon->getIcon());
            $graveyard->addItem($newWeapon);
        }
        $session->set("roomHandler", $roomHandler);
        return "Weapons initiated from database";
    }


    /**
     * Create weapons in db, return list of rooms
     * @return array<int, object>
     */
    private function createDbItems(): array
    {   
        $create = ["shovel", "coin", "tooth"];
        foreach($create as $tool) {
            $newItem = new dbTool();
            $newItem->setName($tool);
            $newItem->setIcon($tool . ".png");
            $this->entityManager->persist($newItem);
            $this->entityManager->flush();
        }

        return $this->entityManager->getRepository(dbWeapon::class)->findAll();
    }

    /**
     * Create item objects in rooms based on items and rooms in database
     *
     * @return string msg
     */
    private function initDbItems($items): string
    {
        $session = $session = $this->requestStack->getSession();
        $roomHandler = $session->get("roomHandler");
        $graveyard = $roomHandler->getRoombyName("graveyard");

        foreach ($items as $item) {
            $newItem = new Item($item->getName(), $item->getIcon());
            $graveyard->addItem($newItem);
        }
        $session->set("roomHandler", $roomHandler);
        return "items from db initiated";
    }

    /**
     * Initiate the dialog
     * Save dialogHandler in session
     * @return void
     */
    private function initDialog(SessionInterface $session): void
    {
        $session->set("dialogHandler", new DialogHandler());
    }

    /**
     * Initiate the human
     *
     * @return void
     */
    private function initHuman(SessionInterface $session): void
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
    private function initDragon(SessionInterface $session): void
    {
        $session->set("dragon", new Dragon());
    }


    /**
     * Reset session variables
     * 
     * @return void
     */
    public function resetSession(): void
    {
        $this->initAdventure();
    }
}
