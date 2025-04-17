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
    #[Route("/api/deck", name: "json_deck", methods: ["GET"])]
    public function jsonDeck(SessionInterface $session): Response {
        $deck = $session->get("deckObject") ?? null; 
        $deckOfCards = $session->get("deckOfCardsJson") ?? null;

        if (!$deck) {
            $deck = new DeckOfCards();
        }

        $deckOfCards = $deck->generateDeckJson();

        // save in session
        $session->set("deckObject", $deck);
        $session->set("deckOfCardsJson", $deckOfCards);

        $response = new JsonResponse($deckOfCards);
        $response->setEncodingOptions(
        $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
