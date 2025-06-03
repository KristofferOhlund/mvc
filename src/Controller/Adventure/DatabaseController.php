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

class DatabaseController extends AbstractController
{   
    /**
     * Show all objets and tables in database
     * @return Response
     */
    #[Route("/proj/about/database", name: "index_database")]
    public function database(): Response
    {   
        return $this->render("adventure/database.html.twig");
    }


    /**
     * CAUTION!
     * Delete entire database
     */
    #[Route("/proj/about/database/delete", name: "delete_database")]
    public function databaseDelete(EntityManagerInterface $entityManager): Response
    {   
        
        $entities = [Room::class, Weapon::class, Food::class, Tool::class];
        foreach($entities as $entity) {
            $objects = $entityManager->getRepository($entity)->findAll();
            foreach($objects as $object) {
                $entityManager->remove($object);
                $entityManager->flush();
            }
        }

        return new Response("Database has been reset");
    }


    /**
     * Show weapon objects in database
     * @return Response
     */
    #[Route("/proj/about/database/weapons", name:"show_weapons")]
    public function showWeapons(EntityManagerInterface $entityManager): Response
    {
        $weapons = $entityManager->getRepository(Weapon::class)->findAll();
        return $this->render("adventure/weapons.html.twig", ["weapons" => $weapons]);
    }


    /**
     * Show room objects in database
     * @return Response
     */
    #[Route("/proj/about/database/rooms", name:"show_rooms")]
    public function showRooms(EntityManagerInterface $entityManager): Response
    {
        $rooms = $entityManager->getRepository(Room::class)->findAll();
        return $this->render("adventure/rooms.html.twig", ["rooms" => $rooms]);
    }


    /**
     * Show food objects in database
     * @return Response
     */
    #[Route("/proj/about/database/foods", name:"show_foods")]
    public function showFoods(EntityManagerInterface $entityManager): Response
    {
        $foods = $entityManager->getRepository(Food::class)->findAll();
        return $this->render("adventure/foods.html.twig", ["foods" => $foods]);
    }


    /**
     * Show tool objects in database
     * @return Response
     */
    #[Route("/proj/about/database/tools", name:"show_tools")]
    public function showTools(EntityManagerInterface $entityManager): Response
    {
        $items = $entityManager->getRepository(Tool::class)->findAll();
        return $this->render("adventure/items.html.twig", ["items" => $items]);
    }
}