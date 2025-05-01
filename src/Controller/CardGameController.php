<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Session\Session;

class CardGameController extends AbstractController
{
    #[Route("/session", name:"session_show")]
    public function showSession(SessionInterface $session): Response
    {

        $data = [
            "deckOfCards" => $session->get("deckOfCards") ?? "null",
            "cardsInHand" => $session->get("cardsInHand") ?? "null",
            "deckObject" => $session->get("deckObject") ?? "null",
            "gameMaster" => $session->get("gameMaster") ?? "null",
        ];

        return $this->render("cards/session.html.twig", $data);
    }



    #[Route("/session/delete", name:"session_dump")]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->set("deckOfCards", null);
        $session->set("cardsInHand", null);
        $session->set("deckObject", null);
        $session->set("gameMaster", null);

        $this->addFlash(
            'notice',
            'Session has been reset'
        );

        return $this->redirectToRoute('session_show');
    }

    #[Route("/card", name:"card")]
    public function card(): Response
    {
        return $this->render("cards/card.html.twig");
    }

    /**
     * If there is no active session, create a new one
     * Creating all 52 cards.
     * @return void
     */
    public function startSession(SessionInterface $session): void
    {
        $deck = new DeckOfCards();
        // $deck->generateDeck();
        $deck->generateGraphicDeck();

        // add to session
        $session->set("deckObject", $deck);
    }


    #[Route("/card/deck", name:"card_deck")]
    public function cardDeck(SessionInterface $session): Response
    {
        $deck = $session->get("deckObject") ?? null;

        // if session is empty, we create a new deck
        if (!$deck) {
            $this->startSession($session);
            $deck = $session->get("deckObject");
        }

        $data = [
            "cards" => $deck->getGraphicCards(),
            "count_cards" => $deck->countGraphicCards(),
        ];

        return $this->render("cards/card_deck.html.twig", $data);
    }


    /**
     * Shuffle all cards in session
     */
    #[Route("/card/deck/shuffle", name:"shuffle")]
    public function cardDeckShuffle(SessionInterface $session): Response
    {
        $deck = $session->get("deckObject") ?? null;

        // if session is empty, we create a new deck
        if (!$deck) {
            $this->startSession($session);
            $deck = $session->get("deckObject");
        }

        // Shuffle all cards
        $deck->shuffleGraphic();

        // Save deck in session
        $session->set("deckObject", $deck);

        $data = [
            "cards" => $deck->getGraphicCards(),
            "count_cards" => $deck->countGraphicCards(),
        ];

        return $this->render("cards/card_deck.html.twig", $data);
    }


    #[Route("/card/deck/draw/{num}", name:"draw", requirements: ['num' => '\d+'])]
    public function drawCardNum(SessionInterface $session, ?int $num = 1): Response
    {
        // hämta deckOfCards från session
        $deck = $session->get("deckObject") ?? null;

        // if session is empty, we create a new deck
        if (!$deck) {
            $this->startSession($session);
            $deck = $session->get("deckObject");
        }

        // validate num range
        $cardCount = $deck->countGraphicCards();

        // current state
        $data = [
            "cards" => null,
            "count_cards" => $cardCount,
            ];

        if ($num < 1 || $num > $cardCount) {
            $this->addFlash(
                'warning',
                'Number is 0 or bigger then the count of Deck'
            );
        } else {
            $removedCards = $deck->drawGraphic($num);
            // update state of data
            $data = [
                "cards" => $removedCards,
                "count_cards" => $deck->countGraphicCards(),
            ];
        }

        // Uppdatera session
        $session->set("deckObject", $deck);

        return $this->render("cards/draw_card.html.twig", $data);
    }
}
