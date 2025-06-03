<?php

/**
 * Module for working with the database
 */

namespace App\Controller\Adventure;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Room;
use App\Entity\Weapon;
use App\Entity\Food;
use App\Entity\Tool;

class InitDbController extends AbstractController
{   
    /**
     * Create all Rooms nessescary for the Adventure Game
     * 
     * @return Response
     */
    #[Route("/proj/about/database/initrooms", name:"init_rooms")]
    public function initAdventureRooms(EntityManagerInterface $entityManager): Response
    {
        $rooms = ["graveyard", "house", "apple", "dragon"];
        $existingRooms = array_map(fn($room) => $room->getName(), $entityManager->getRepository(Room::class)->findAll());

        foreach($rooms as $room) {
            if (!in_array($room, $existingRooms)) {
                $newRoom = new Room();
                $newRoom->setName($room);
                $newRoom->setBackground($room . ".png");
                $entityManager->persist($newRoom);
                $entityManager->flush($newRoom);
            } 
        }

        $existingRoomObjects = $entityManager->getRepository(Room::class)->findAll();
        return $this->json($existingRoomObjects);
    }

    /**
     * Create all Weapons nessescary for the Adventure Game
     * 
     * @return Response
     */
    #[Route("/proj/about/database/initweapons", name:"init_weapons")]
    public function initAdventureWeapons(EntityManagerInterface $entityManager): Response
    {
        $rooms = ["graveyard", "house", "apple", "dragon"];
        $existingRooms = array_map(fn($room) => $room->getName(), $entityManager->getRepository(Room::class)->findAll());

        foreach($rooms as $room) {
            if (!in_array($room, $existingRooms)) {
                $newRoom = new Room();
                $newRoom->setName($room);
                $newRoom->setBackground($room . ".png");
                $entityManager->persist($newRoom);
                $entityManager->flush($newRoom);
            } 
        }

        $existingRoomObjects = $entityManager->getRepository(Room::class)->findAll();
        return $this->json($existingRoomObjects);
    }

    /**
     * Create all Weapons nessescary for the Adventure Game
     * 
     * @return Response
     */
    #[Route("/proj/about/database/initfoods", name:"init_foods")]
    public function initAdventureFoods(EntityManagerInterface $entityManager): Response
    {
        $rooms = ["graveyard", "house", "apple", "dragon"];
        $existingRooms = array_map(fn($room) => $room->getName(), $entityManager->getRepository(Room::class)->findAll());

        foreach($rooms as $room) {
            if (!in_array($room, $existingRooms)) {
                $newRoom = new Room();
                $newRoom->setName($room);
                $newRoom->setBackground($room . ".png");
                $entityManager->persist($newRoom);
                $entityManager->flush($newRoom);
            } 
        }

        $existingRoomObjects = $entityManager->getRepository(Room::class)->findAll();
        return $this->json($existingRoomObjects);
    }

    /**
     * Create all Weapons nessescary for the Adventure Game
     * 
     * @return Response
     */
    #[Route("/proj/about/database/inittools", name:"init_tools")]
    public function initAdventureTools(EntityManagerInterface $entityManager): Response
    {
        $tools = ["shovel", "coin", "tooth", "skull", "key"];
        $existingTools = array_map(fn($room) => $room->getName(), $entityManager->getRepository(Room::class)->findAll());

        foreach($tools as $tool) {
            if (!in_array($tool, $existingTools)) {
                $newTool = new Tool();
                $newTool->setName($tool);
                $newTool->setIcon($tool . ".png");
                $entityManager->persist($newTool);
                $entityManager->flush($newTool);
            } 
        }

        $existingRoomObjects = $entityManager->getRepository(Room::class)->findAll();
        return $this->json($existingRoomObjects);
    }
}