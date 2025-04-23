<?php

namespace App\Controller;

use PDepend\Metrics\Analyzer\CodeRankAnalyzer\MethodStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Game\Player;
use App\Game\Bank;

class GameController extends AbstractController {
    public function createSession(SessionInterface $session) {
        
        $session->set("player", new Player("Kingen"));
        $session->set("player", new Bank("Bank"));
        $session->set("deckOfCards", new DeckOfCards());

        // $session["bank"] = new Bank();
    }

    #[Route("/game/destroy", name:"game_destroy")]
    public function gameDestroy(SessionInterface $session) {
        $session->set("player", null);
        $session->set("bank", null);
        $session->set("deckOfCards", null);

        return $this->redirectToRoute(("game_play"));
    }

    #[Route("/game", name:"game_info")]
    public function game(): Response {
        return $this->render("game/game-info.html.twig");
    }

    #[Route("/game/play", name:"game_play", methods:["GET"])]
    public function gamePlay(SessionInterface $session): Response {
        
        $player = $session->get("player") ? null : $this->createSession($session);
        $player = $session->get("player");

        $data = [
            "player" => $player
        ];

        return $this->render("game/game-play.html.twig", $data);
    }

    #[Route("/game/play", name:"game_roll", methods:["POST"])]
    public function gameRoll(SessionInterface $session): Response {


        return $this->redirectToRoute(("game_play"));
    }

    #[Route("/game/doc", name:"game_doc")]
    public function gameDoc(): Response {
        return $this->render("game/game-doc.html.twig");
    }
}