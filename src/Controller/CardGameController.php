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
use App\Card\deckOfCards;
use Symfony\Component\HttpFoundation\Session\Session;

class CardGameController extends AbstractController
{
    private const SESSION_VARIABLES = [
        1 => "deckOfCards",
        2 => "cardsInhand"
    ];

    #[Route("/session", name:"session_show")]
    public function showSession(SessionInterface $session): Response {

        $data = [
            "deckOfCards" => $session->get("deckOfCards") ?? "null",
            "cardsInHand" => $session->get("cardsInHand") ?? "null"
        ];

        return $this->render("cards/session.html.twig", $data);
    }
    


    #[Route("/session/delete", name:"session_dump")]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->set("deckOfCards", null);
        $session->set("cardsInhand", null);

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


    #[Route("/card/deck", name:"card_deck")]
    public function cardDeck(SessionInterface $session): Response
    {
        $deckOfCards = $session->get("deckOfCards") ?? null;

        // if session is empty, we create a new deck
        if (!$deckOfCards) {
            $deckOfCards = new DeckOfCards();

            $names = ["spader", "hjärter", "ruter", "klöver"];
            sort($names);
            $values = ["ess", "2", "3", "4", "5", "6", "7", "8", "9", "10", "knekt", "dam", "kung"];

            foreach($names as $name) {
                foreach($values as $value) {
                    $card = new CardGraphic($value, $name);
                    $deckOfCards->add($card);
                }
            }
        }

        // add to session
        $session->set("deckOfCards", $deckOfCards);
        $session->set("card_amount", $deckOfCards->countCards());

        $data = [
            "cards" => $deckOfCards->getCards(),
            "count_cards" => $deckOfCards->countCards(),
            "sort" => "sorted"
        ];

        return $this->render("cards/card_deck.html.twig", $data);
    }

    /**
     * Route resets the deck to 52 cards, and shuffles it in random order.
     * Todo: make the creation of cards and symbols DRY, now does the same
     * thing in /card/deck if cards are not in session.
     */
    #[Route("/card/deck/shuffle", name:"shuffle")]
    public function cardDeckShuffle(SessionInterface $session): Response
    {
        // Always reset deck
        $deckOfCards = new DeckOfCards();

        $names = ["spader", "hjärter", "ruter", "klöver"];
        sort($names);
        $values = ["ess", "2", "3", "4", "5", "6", "7", "8", "9", "10", "knekt", "dam", "kung"];

        foreach($names as $name) {
            foreach($values as $value) {
                $card = new CardGraphic($value, $name);
                $deckOfCards->add($card);
                }
            }
        
        // Shuffle all cards
        $deckOfCards->shuffleCards();

        // Save deck in session
        $session->set("deckOfCards", $deckOfCards);

        $data = [
            "cards" => $deckOfCards->getCards(),
            "count_cards" => $deckOfCards->countCards(),
            "sort" => "shuffled"
        ];

        return $this->render("cards/card_deck.html.twig", $data);
    }

    #[Route("/card/deck/draw", name:"draw")]
    public function drawCard(SessionInterface $session): Response {
        // hämta deckOfCards från session
        $deckOfCards = $session->get("deckOfCards");
        $drawCard = $deckOfCards->draw();

        $data = [
            "card" => $drawCard->getSymbol(),
            "count_cards" => $deckOfCards->countCards()
        ];

        // Uppdatera session
        $session->set("deckOfCards", $deckOfCards);
        
        return $this->render("cards/single_card.html.twig", $data);
    }
}