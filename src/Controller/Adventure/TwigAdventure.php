<?php

/**
 * Main Controller module
 */

namespace App\Controller\Adventure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
// ADVENTURE
use App\Adventure\Weapon;
use App\Adventure\Food;
use App\Adventure\Item;
use App\Entity\Food as dbFood;
use App\Entity\Weapon as dbWeapon;
use App\Entity\Tool as dbTool;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TwigAdventure extends AbstractController
{
    /**
     * Some data variables are the same for each route
     * Use method to get basic data and extend data in route
     * Returns roomObjects stored in room
     * @param Session $session - current session
     * @param string $roomName - the current room
     * @return array<mixed>
     */
    private function getDataByRoom(Session $session, string $roomName): array
    {
        $roomHandler = $session->get("roomHandler");
        $dialogHandler = $session->get("dialogHandler");
        $human = $session->get("human");
        $dragon = $session->get("dragon");
        $validRooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        if (!in_array($roomName, $validRooms)) {
            throw new Exception("Room $roomName is not a valid room");
        }

        $room = $roomHandler->getRoomByName($roomName);
        $data = [
            "msg" => $dialogHandler->getDialogByStatus(),
            "human" => $human,
            "dragon" => $dragon,
            "backpack" => array_map(fn ($item) => $item->getName(), $human->getItemsInBag()), // get all item names in bg
            "img" => $room->getImg(),
            "room" => $room,
            "roomObjects" => $room->getItems(),
            "next" => $roomHandler->getNext($roomName),
            "prev" => $roomHandler->getPrev($roomName)
        ];

        return $data;
    }

    /**
     * Init the adventure
     * Call sessionHandler to setup all game and session variables
     * @return RedirectResponse
     */
    #[Route("/proj/init", name:"init_adventure")]
    public function init(SessionHandler $sessionHandler): RedirectResponse
    {
        // Get data for current room
        $sessionHandler->initAdventure();
        return $this->redirectToRoute("graveyard");
    }

    /**
     * Route for the graveyard aka the first room of the Adventure
     * Fetch current data
     * @return Response
     */
    #[Route("/proj/graveyard", name:"graveyard")]
    public function graveyard(Session $session): Response
    {
        // Get data for current room
        $data = $this->getDataByRoom($session, "graveyard");
        return $this->render("adventure/graveyard.html.twig", $data);
    }

    /**
     * Route for the house aka the second room of the Adventure
     * Fetch current data
     * @return Response
     */
    #[Route("/proj/house", name:"house")]
    public function house(Session $session): Response
    {
        // Get data for current room
        $data = $this->getDataByRoom($session, "house");
        return $this->render("adventure/house.html.twig", $data);
    }

    /**
     * Route for the house aka the third room of the Adventure
     * Fetch current data
     * @return Response
     */
    #[Route("/proj/apple", name:"apple")]
    public function apple(Session $session): Response
    {
        // Get data for current room
        $data = $this->getDataByRoom($session, "apple");
        return $this->render("adventure/apple.html.twig", $data);
    }

    /**
     * Route for the house aka the last room of the Adventure
     * Fetch current data
     * @return Response
     */
    #[Route("/proj/dragon", name:"dragon")]
    public function dragon(Session $session): Response
    {
        // Get data for current room
        $data = $this->getDataByRoom($session, "dragon");
        return $this->render("adventure/dragon.html.twig", $data);
    }

    /**
     * Route for when successfully killing the dragon
     * @return Response
     */
    #[Route("/proj/win", name:"win")]
    public function win(): Response
    {
        return $this->render("adventure/win.html.twig");
    }

    /**
     * Route for when killed by the dragon
     * @return Response
     */
    #[Route("/proj/lost", name:"lost")]
    public function lost()
    {
        return $this->render("adventure/lost.html.twig");
    }

    /**
     * Route for equipping an item
     * Equips the item and returns a rederict to the referer_route
     * @return RedirectResponse
     */
    #[Route("/proj/item", name:"equip_item", methods:["POST"])]
    public function equipItem(Request $request, EntityManagerInterface $entitymanager): RedirectResponse
    {
        // fetch item
        $posted = $request->request->all();
        $route = $posted["referer_route"];
        $item = $posted["item"] ?? null;

        // redirect if equip is pressed without a selected option
        if (!$item) {
            return $this->redirectToRoute($route);
        }

        $icon = $item . ".png";

        // add to humans backpack
        $session = $request->getSession();
        $human = $session->get("human") ?? "Human finns inte";


        if ($item === "Apple") {
            $apple = $entitymanager->getRepository(dbFood::class)->findFoodByName($item);
            $human->addItemToBackPack(new Food($apple->getName(), $apple->getHealingValue(), $apple->getIcon()));
        } elseif ($item !== "Sword") {
            $tool = $entitymanager->getRepository(dbTool::class)->findToolByName($item);
            $human->addItemToBackPack(new Item($tool->getName(), $tool->getIcon()));
        } if ($item === "Sword") {
            $sword = $entitymanager->getRepository(dbWeapon::class)->findWeaponByName($item);
            $human->addWeapon(new Weapon($sword->getName(), $sword->getDmg(), $sword->getIcon()));
        }

        $this->addFlash("notice", "You equipped the $item");

        // rum i route
        $dialogHandler = $session->get("dialogHandler");
        $dialogHandler->setCurrentRoom($route);
        $dialogHandler->setCurrentItem($item);
        return $this->redirectToRoute($route);
    }

    /**
     * Route for using an item, aka action
     * Action could be using a Shovel to dig some secrets,
     * Returns a rederict to the referer_route
     * @return RedirectResponse
     */
    #[Route("/proj/action", name:"use_item", methods:["POST"])]
    public function useItem(Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
        $posted = $request->request->all();
        $route = $posted["referer_route"];
        $action = $posted["action"] ?? null;

        $session = $request->getSession();
        $roomHandler = $session->get("roomHandler");

        if ($action === "dig") {
            $key = $entityManager->getRepository(dbTool::class)->findToolByName("Key");
            $itemObj = new Item($key->getName(), $key->getIcon());
            // rum i route
            $dialogHandler = $session->get("dialogHandler");
            $dialogHandler->setCurrentRoom($route);
            $dialogHandler->setCurrentItem($itemObj->getName());
            $roomHandler->addItemToRoom($route, $itemObj);

        } if ($action === "unlock") {
            $food = $entityManager->getRepository(dbFood::class)->findFoodByName("Apple");
            $itemObj = new Item($food->getName(), $food->getIcon());
            $route = "apple";
            $dialogHandler = $session->get("dialogHandler");
            $dialogHandler->setCurrentRoom($route);
            $dialogHandler->setCurrentItem($itemObj->getName());
            $roomHandler->addItemToRoom($route, $itemObj);
        }

        return $this->redirectToRoute($route);
    }

    /**
     * Attacking the dragon, each attack also makes the dragon attack you back
     * Returns a rederict to the dragon route
     * @return RedirectResponse
     */
    #[Route("/proj/attack", name:"attack", methods:["POST"])]
    public function attack(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $human = $session->get("human");
        $dmg = $human->attackWithWeapon();

        $this->addFlash("notice", "You strike the dragon with your weapon, dealing $dmg dmg");

        $dragon = $session->get("dragon");
        $dragon->reduceHealth((int) $dmg);

        if ($dragon->getHealth() < 0) {
            return $this->redirectToRoute("win");
        }

        $dragonDmg = $dragon->sprayFire();
        $human->reduceHealth((int) $dragonDmg);

        $this->addFlash("notice", "The dragon roars and draws his breath, filling the entire room with fire");

        if ($human->getHealth() < 0) {
            return $this->redirectToRoute("lost");
        }

        return $this->redirectToRoute("dragon");
    }

    /**
     * Route when eating a food item
     * Eaths the food to restore some health
     * @return RedirectResponse
     */
    #[Route("/proj/eat", name:"eat", methods:["POST"])]
    public function eat(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $human = $session->get("human");
        $human->eatFood($human->getItemByName("Apple"));
        return $this->redirectToRoute("dragon");
    }
}
