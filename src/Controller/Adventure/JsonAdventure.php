<?php

/**
 * JSON Controllers
 */

namespace App\Controller\Adventure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
// ADVENTURE
use App\Controller\Adventure\SessionHandler;
use App\Adventure;
use App\Adventure\BackPack;
use App\Adventure\Food;
use App\Adventure\Weapon;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JsonAdventure extends AbstractController
{
    /**
     * Json index page
     * @return Response
     */
    #[Route("/proj/json/index", name:"json_index")]
    public function jsonIndex(): Response
    {
        return $this->render("adventure/json.html.twig");
    }

    /**
     * Initiate the game
     * @return Response
     */
    #[Route("/proj/json/init", name:"json_init")]
    public function initAdventure(Session $session, SessionHandler $sessionHandler): Response
    {
        $sessionHandler->initAdventure();
        $roomHandler = $session->get("roomHandler");
        $human = $session->get("human");
        $dragon = $session->get("dragon");

        $data = [
            "human" => $human,
            "dragon" => $dragon,
            "rooms" => $roomHandler
        ];

        $response = $this->json($data);
        $response->setEncodingOptions($response->getEncodingOptions());
        return $response;
    }

    /**
     * Equip a sword
     * @return Response
     */
    #[Route("/proj/json/equip", name:"json_equip", methods:["POST"])]
    public function equipSword(Request $request): Response
    {
        $post = (string)$request->request->get("item");
        $sword = new Weapon($post, 100, "sword.png");
        $session = $request->getSession();
        $human = $session->get("human");
        $human->addWeapon($sword);

        $data = [
            "human" => $human,
            "weapon" => $sword
        ];

        return $this->json($data)->setEncodingOptions(JSON_PRETTY_PRINT);
    }


    /**
     * Eat an apple to increase the players health
     * @return Response
     */
    #[Route("/proj/json/eat", name:"json_eat", methods:["POST"])]
    public function eatApple(Request $request): Response
    {
        $post = (string)$request->request->get("item");
        $food = new Food($post, 100, "apple.png");
        $session = $request->getSession();
        $human = $session->get("human");
        $backpack = new BackPack();
        $human->equipBackPack($backpack);
        $human->addItemToBackPack($food);
        $human->eatFood($food);

        $data = [
            "human" => $human,
            "food" => $food
        ];

        return $this->json($data)->setEncodingOptions(JSON_PRETTY_PRINT);
    }


    /**
     * Attack the dragon
     * @return Response
     */
    #[Route("/proj/json/attack", name:"json_attack")]
    public function attack(Request $request): Response
    {
        $session = $request->getSession();
        $human = $session->get("human");
        $dmg = $human->attackWithWeapon();

        $dragon = $session->get("dragon");
        $dragon->reduceHealth((int) $dmg);

        if ($dragon->getHealth() < 0) {
            return $this->json(["Congratulations, you killed the dragon"]);
        }

        $dragonDmg = $dragon->sprayFire();
        $human->reduceHealth((int) $dragonDmg);

        if ($human->getHealth() < 0) {
            return $this->json(["You got killed by the dragon!"]);
        }

        $data = [
            "human" => $human,
            "dragon" => $dragon
        ];

        return $this->json($data)->setEncodingOptions(JSON_PRETTY_PRINT);
    }


    /**
     * Show human and dragon stats
     */
    #[Route("/proj/json/rooms", name:"json_stats")]
    public function showStats(Request $request): Response
    {
        $session = $request->getSession();
        $roomHandler = $session->get("roomHandler");

        $data = [
            "rooms" => $roomHandler->getAllRooms()
        ];

        return $this->json($data);
    }


    /**
     * Reset current session by redirecting to json_init
     * @return RedirectResponse
     */
    #[Route("/proj/json/reset", name:"json_reset")]
    public function reset(): RedirectResponse
    {
        return $this->redirectToRoute("json_init");
    }
}
