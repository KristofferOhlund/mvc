<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\DeckOfCards;

class CardJsonApiController extends AbstractController
{
    /**
     * If there is no active session, create a new one
     * Creating all 52 cards.
     * @return void
     */
    public function startSession(SessionInterface $session): void
    {
        $deck = new DeckOfCards();
        $deck->generateDeck();

        // add to session
        $session->set("deckObject", $deck);
    }


    #[Route("/api/deck", name: "json_deck", methods: ["GET"])]
    public function jsonDeck(SessionInterface $session): JsonResponse
    {
        $deck = $session->get("deckObject") ?? null;

        // if session is empty, we create a new deck
        if (!$deck) {
            $this->startSession($session);
            $deck = $session->get("deckObject");
        }


        // save in session
        $session->set("deckObject", $deck);

        $response = new JsonResponse($deck->getCards());
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "json_shuffle", methods: ["GET", "POST"])]
    public function jsonShuffle(SessionInterface $session): JsonResponse
    {
        $deck = $session->get("deckObject") ?? null;

        // if session is empty, we create a new deck
        if (!$deck) {
            $this->startSession($session);
            $deck = $session->get("deckObject");
        }

        $deck->shuffleCards();

        // save in session
        $session->set("deckObject", $deck);

        $response = new JsonResponse($deck->getCards());
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{num}", name:"json_draw", requirements: ['num' => '\d+'], methods: ["POST", "GET"])]
    public function drawCardNum(SessionInterface $session, ?int $num = 1): JsonResponse
    {
        $deck = $session->get("deckObject") ?? null;

        // if session is empty, we create a new deck
        if (!$deck) {
            $this->startSession($session);
            $deck = $session->get("deckObject");
        }

        $removed_cards = $deck->draw($num);

        $session->set("deckObject", $deck);
        $session->set("removed_cards", $removed_cards);

        $data = [
            "cards_left" => $deck->countCards(),
            "removed_cards" => $removed_cards
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }

    #[Route("/api/game", name:"game_api")]
    public function gameApi(SessionInterface $session)
    {
        $player = $session->get("player");
        $bank = $session->get("bank") ? $session->get("bank") : null;

        $data = [
            "player" => [
                "points" => $player->getPoints(),
                "cards" => join(",", $player->showSymbolsInHand())
            ],
            "bank" => [
                "points" => $bank->getPoints(),
                "cards" => join(",", $bank->showSymbolsInHand())
            ],
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }
}
