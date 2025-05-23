<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\DeckOfCards;
use App\Game\Player;
use App\Game\Bank;
use App\Game\GameMaster;

class GameController extends AbstractController
{
    private const SESSIONATTRIBUTES = [
        "player",
        "bank",
        "deckOfCards",
        "gameMaster"
    ];

    private function createSession(SessionInterface $session): void
    {
        // CREATE OBJECTS
        $player = new Player("Player");
        $gameMaster = new GameMaster($player);
        $deckOfCards = new DeckOfCards();
        $deckOfCards->generateGraphicDeck();
        $deckOfCards->shuffleGraphic();

        // CREATE ALL ATTRIBUTES
        $session->set(self::SESSIONATTRIBUTES[2], $deckOfCards);
        $session->set(self::SESSIONATTRIBUTES[3], $gameMaster);
    }

    private function checkSession(SessionInterface $session): void
    {
        // Make sure all attributes are set
        // Else create new instances of all
        $sessionAttributes = ["deckOfCards", "gameMaster"];
        foreach ($sessionAttributes as $attribute) {
            if ($session->get($attribute) == null) {
                $this->createSession($session);
            }
        }
    }

    #[Route("/game/destroy", name:"game_destroy")]
    public function gameDestroy(SessionInterface $session): Response
    {
        $session->set("deckOfCards", null);
        $session->set("gameMaster", null);

        return $this->redirectToRoute("multiplayer_get");
    }

    #[Route("/game", name:"game_info")]
    public function game(): Response
    {
        return $this->render("game/game-info.html.twig");
    }

    #[Route("/game/play", name:"game_play", methods:["GET"])]
    public function gamePlay(SessionInterface $session): Response
    {
        // CHECK SESSION
        $this->checkSession($session);

        // GET SESSION
        $gameMaster = $session->get(self::SESSIONATTRIBUTES[3]);

        // CHECK IF PLAYERS ARE DONE
        if ($gameMaster->checkPlayersDone()) {
            return $this->redirectToRoute("bank_init");
        };

        // GET CURRENT PLAYER
        $currentPlayer = $gameMaster->peek();

        // SET CURRENT PLAYER
        $session->set("currentPlayer", $currentPlayer);

        $data = [
            "player" => $currentPlayer,
        ];

        return $this->render("game/game-play.html.twig", $data);
    }

    #[Route("/game/roll", name:"game_roll", methods:["GET"])]
    public function gameRoll(SessionInterface $session): Response
    {
        // GET SESSION
        $currentPlayer = $session->get("currentPlayer");
        $deckOfCards = $session->get(self::SESSIONATTRIBUTES[2]);
        $card = $currentPlayer->drawCard($deckOfCards);
        $currentPlayer->addCard($card);

        return $this->redirectToRoute("game_play");
    }

    #[Route("/game/roll/stop", name:"roll_stop", methods:["GET"])]
    public function rollStop(SessionInterface $session): Response
    {
        // GET SESSION
        $currentPlayer = $session->get("currentPlayer");
        $currentPlayer->stop();

        $gameMaster = $session->get(self::SESSIONATTRIBUTES[3]);
        $gameMaster->dequeue();

        return $this->redirectToRoute("game_play");
    }


    #[Route("/game/bank/init", name:"bank_init")]
    public function bankInit(SessionInterface $session): Response
    {
        $gameMaster = $session->get(self::SESSIONATTRIBUTES[3]);
        $bank = $gameMaster->getBank();
        $deckOfCards = $session->get(self::SESSIONATTRIBUTES[2]);
        $bank->bankDrawCard($deckOfCards);

        return $this->redirectToRoute("game_winner");
    }


    #[Route("/game/winner", name:"game_winner", methods:["GET"])]
    public function showWinner(SessionInterface $session): Response
    {
        // GET SESSION
        $gameMaster = $session->get(self::SESSIONATTRIBUTES[3]);
        $result = $gameMaster->declareWinner();
        $data = [
            "winner" => $result["winner"],
            "players" => $result["players"],
            "bank" => $result["bank"],
        ];

        return $this->render("game/game-winner.html.twig", $data);
    }


    #[Route("/game/doc", name:"game_doc")]
    public function gameDoc(): Response
    {
        return $this->render("game/game-doc.html.twig");
    }


    #[Route("/game/multiplayer/init", name:"multiplayer_get", methods:["GET"])]
    public function multiplayer(): Response
    {
        return $this->render("game/game-form.html.twig");
    }


    #[Route("/game/multiplayer", name:"multiplayer_post", methods:["POST"])]
    public function multiplayerCallback(Request $request, SessionInterface $session): Response
    {
        $playerCount = intval($request->get("player_amount"));
        $players = [];
        for ($i = 1; $i < $playerCount + 1; $i++) {
            $players[] = new Player("Player $i");
        }

        // CREATE GAME INSTANCE
        $gameMaster = new GameMaster(...$players);
        $deckOfCards = new DeckOfCards();
        $deckOfCards->generateGraphicDeck();
        $deckOfCards->shuffleGraphic();

        // SET SESSION
        $session->set(self::SESSIONATTRIBUTES[2], $deckOfCards);
        $session->set(self::SESSIONATTRIBUTES[3], $gameMaster);

        return $this->redirectToRoute("game_play");
    }
}
