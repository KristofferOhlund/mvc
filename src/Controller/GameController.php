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
use App\Game\GameMaster;

class GameController extends AbstractController {
    private const SESSIONATTRIBUTES = [
        "player",
        "bank",
        "deckOfCards",
        "gameMaster"
    ];

    public function createSession(SessionInterface $session) {
        // CREATE OBJECTS
        $player = new Player("Kingen");
        $bank = new Bank("Bank");
        $deckOfCards = new DeckOfCards();
        $deckOfCards->generateGraphicDeck();
        $deckOfCards->shuffleGraphic();
        $deckOfCards->shuffleGraphic();
        $deckOfCards->shuffleGraphic();

        // CREATE ALL ATTRIBUTES
        $session->set(self::SESSIONATTRIBUTES[0], $player);
        $session->set(self::SESSIONATTRIBUTES[1], $bank);
        $session->set(self::SESSIONATTRIBUTES[2], $deckOfCards);
        $session->set(self::SESSIONATTRIBUTES[3], new GameMaster($player, $bank));
    }

    public function checkSession(SessionInterface $session) {
        // Make sure all attributes are set
        // Else create new instances of all
        $sessionAttributes = ["player", "bank", "deckOfCards", "gameMaster"];
        foreach($sessionAttributes as $attribute) {
            if ($session->get($attribute) == null) {
                $this->createSession($session);
            }
        }
    }

    #[Route("/game/destroy", name:"game_destroy")]
    public function gameDestroy(SessionInterface $session) {
        $session->set("player", null);
        $session->set("bank", null);
        $session->set("deckOfCards", null);
        $session->set("gameMaster", null);

        return $this->redirectToRoute("game_play");
    }

    #[Route("/game", name:"game_info")]
    public function game(): Response {
        return $this->render("game/game-info.html.twig");
    }

    #[Route("/game/play", name:"game_play", methods:["GET"])]
    public function gamePlay(SessionInterface $session): Response {

        // CHECK SESSION
        $this->checkSession($session);
        
        // GET SESSION
        $player = $session->get(self::SESSIONATTRIBUTES[0]);
        $bank = $session->get(self::SESSIONATTRIBUTES[1]);
        $gameMaster = $session->get(self::SESSIONATTRIBUTES[3]);

        // GET CURRENT PLAYER
        $currentPlayer = $gameMaster->peek();
        // SET CURRENT PLAYER
        $session->set("currentPlayer", $currentPlayer);

        // Check if round is over
        if ($gameMaster->checkGameStop()) {
            return $this->redirectToRoute("game_winner");
        };
        
        $data = [
            "currentPlayer" => $currentPlayer->getName(),
            "player" => $player,
            "bank" => $bank,
        ];

        return $this->render("game/game-play.html.twig", $data);
    }

    #[Route("/game/roll", name:"game_roll", methods:["GET"])]
    public function gameRoll(SessionInterface $session): Response {
        // GET SESSION
        $currentPlayer = $session->get("currentPlayer");
        $deckOfCards = $session->get(self::SESSIONATTRIBUTES[2]);
        $card = $currentPlayer->drawCard($deckOfCards);
        $currentPlayer->addCard($card);

        return $this->redirectToRoute("game_play");
    }

    #[Route("/game/roll/stop", name:"roll_stop", methods:["GET"])]
    public function rollStop(SessionInterface $session): Response {
        // GET SESSION
        $currentPlayer = $session->get("currentPlayer");
        $currentPlayer->stop();

        $gameMaster = $session->get(SELF::SESSIONATTRIBUTES[3]);

        if ($gameMaster->getSize() > 1) {
            $gameMaster->dequeue();
        } 

        return $this->redirectToRoute("bank_init");
        // return $this->redirectToRoute("game_play");
        // return $this->render("game/draw-test.html.twig", $data);
    }

    #[Route("/game/bank/init", name:"bank_init")]
    public function bankInit(SessionInterface $session) {
        $gameMaster = $session->get(self::SESSIONATTRIBUTES[3]);
        $deckOfCards = $session->get(self::SESSIONATTRIBUTES[2]);
        $gameMaster->bankRoll($deckOfCards);

        return $this->redirectToRoute("game_play");
    }


    #[Route("/game/winner", name:"game_winner", methods:["GET"])]
    public function showWinner(SessionInterface $session): Response {
        // GET SESSION
        $gameMaster = $session->get(SELF::SESSIONATTRIBUTES[3]);
        $result = $gameMaster->declareWinner();
        $data = [
            "winner" => $result["winner"],
            "looser" => $result["looser"],
        ];

        // return $this->redirectToRoute("game_play");
        return $this->render("game/game-winner.html.twig", $data);
    }




    #[Route("/game/doc", name:"game_doc")]
    public function gameDoc(): Response {
        return $this->render("game/game-doc.html.twig");
    }
}