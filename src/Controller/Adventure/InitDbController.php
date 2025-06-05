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
        $existingRooms = array_map(fn ($room) => $room->getName(), $entityManager->getRepository(Room::class)->findAll());

        foreach ($rooms as $room) {
            if (!in_array($room, $existingRooms)) {
                $newRoom = new Room();
                $newRoom->setName($room);
                $newRoom->setBackground($room . ".png");
                $entityManager->persist($newRoom);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute("index_database");
    }

    /**
     * Create all Weapons nessescary for the Adventure Game
     *
     * @return Response
     */
    #[Route("/proj/about/database/initweapons", name:"init_weapons")]
    public function initAdventureWeapons(EntityManagerInterface $entityManager): Response
    {
        $sword = new Weapon();
        $sword->setName("Sword");
        $sword->setDmg(100);
        $sword->setIcon("Sword.png");

        $result = $entityManager->getRepository(Weapon::class)->findWeaponByName("Sword");
        if (!$result) {
            $entityManager->persist($sword);
            $entityManager->flush();
        }

        return $this->redirectToRoute("index_database");
    }

    /**
     * Create all Weapons nessescary for the Adventure Game
     *
     * @return Response
     */
    #[Route("/proj/about/database/initfoods", name:"init_foods")]
    public function initAdventureFoods(EntityManagerInterface $entityManager): Response
    {
        $food = new Food();
        $food->setName("Apple");
        $food->setHealingValue(100);
        $food->setIcon("Apple.png");

        $result = $entityManager->getRepository(Food::class)->findFoodByName("Apple");
        if (!$result) {
            $entityManager->persist($food);
            $entityManager->flush();
        }

        return $this->redirectToRoute("index_database");
    }

    /**
     * Create all Weapons nessescary for the Adventure Game
     *
     * @return Response
     */
    #[Route("/proj/about/database/inittools", name:"init_tools")]
    public function initAdventureTools(EntityManagerInterface $entityManager): Response
    {
        $tools = ["Shovel", "Coin", "Tooth", "Key"];

        foreach ($tools as $tool) {
            $result = $entityManager->getRepository(Tool::class)->findToolByName($tool);
            if (!$result) {
                $newTool = new Tool();
                $newTool->setName($tool);
                $newTool->setIcon($tool.".png");
                $entityManager->persist($newTool);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute("index_database");
    }
}
