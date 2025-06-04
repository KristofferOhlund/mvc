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
    public function database(EntityManagerInterface $entityManager): Response
    {
        $rooms = $entityManager->getRepository(Room::class)->findAll();
        $weapons = $entityManager->getRepository(Weapon::class)->findAll();
        $foods = $entityManager->getRepository(Food::class)->findAll();
        $items = $entityManager->getRepository(Tool::class)->findAll();

        $data = [
            "rooms" => $rooms,
            "weapons" => $weapons,
            "foods" => $foods,
            "items" => $items,
        ];

        return $this->render("adventure/database.html.twig", $data);
    }


    /**
     * CAUTION!
     * Delete entire database
     */
    #[Route("/proj/about/database/delete", name: "delete_database")]
    public function databaseDelete(EntityManagerInterface $entityManager): Response
    {
        $entities = [Room::class, Weapon::class, Food::class, Tool::class];
        foreach ($entities as $entity) {
            $objects = $entityManager->getRepository($entity)->findAll();
            foreach ($objects as $object) {
                $entityManager->remove($object);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute("index_database");
    }
}
