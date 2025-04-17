<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
    public function startSession($session): void
    {
        $deck = new DeckOfCards();
        $deck->generateDeckJson();

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

        $response = new JsonResponse($deck->getJsonCards());
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

        $deck->shuffleCardsJson();

        // save in session
        $session->set("deckObject", $deck);

        $response = new JsonResponse($deck->getJsonCards());
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

        $removed_cards = $deck->drawJson($num);

        $session->set("deckObject", $deck);
        $session->set("removed_cards", $removed_cards);

        $data = [
            "cards_left" => $deck->countCardsJson(),
            "removed_cards" => $removed_cards
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }

}
