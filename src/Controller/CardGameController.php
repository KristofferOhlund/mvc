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
use App\Card\DecOfCards;
use Symfony\Component\HttpFoundation\Session\Session;

class CardGameController extends AbstractController
{
    private const SESSION_VARIABLES = [
        1 => "decOfCards",
        2 => "cardsInhand"
    ];

    #[Route("/session", name:"session_show")]
    public function showSession(SessionInterface $session): Response {

        $data = [
            "decOfCards" => $session->get("decOfCards") ?? "null",
            "cardsInHand" => $session->get("cardsInHand") ?? "null"
        ];

        return $this->render("cards/session.html.twig", $data);
    }
    


    #[Route("/session/delete", name:"session_dump")]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->set("decOfCards", null);
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
        $decOfCards = $session->get("deckOfCards") ?? null;

        // if session is empty, we create a new deck
        if (!$decOfCards) {
            $decOfCards = new DecOfCards();

            $names = ["spader", "hjärter", "ruter", "klöver"];
            sort($names);
            $values = ["ess", "2", "3", "4", "5", "6", "7", "8", "9", "10", "knekt", "dam", "kung"];

            foreach($names as $name) {
                foreach($values as $value) {
                    $card = new CardGraphic($value, $name);
                    $decOfCards->add($card);
                }
            }
        }

        // add to session
        $session->set("decOfCards", $decOfCards);
        $session->set("card_amount", $decOfCards->countCards());

        $data = [
            "cards" => $decOfCards->getCards(),
            "count_cards" => $decOfCards->countCards(),
            "sort" => "sorted"
        ];

        return $this->render("cards/card_deck.html.twig", $data);
    }


    #[Route("/card/deck/shuffle", name:"card_deck_shuffle")]
    public function cardDeckShuffle(SessionInterface $session): Response
    {
        // hämta decOfCards från session
        $decOfCards = $session->get("decOfCards");
        $decOfCards->shuffleCards();
        $data = [
            "cards" => $decOfCards->getCards(),
            "sort" => "shuffled"
        ];

        return $this->render("cards/card_deck.html.twig", $data);
    }

    #[Route("/card/deck/draw", name:"draw_card")]
    public function drawCard(SessionInterface $session): Response {
        // hämta decOfCards från session
        $decOfCards = $session->get("decOfCards");
        $drawCard = $decOfCards->draw();

        $data = [
            "card" => $drawCard->getSymbol(),
            "count_cards" => $decOfCards->countCards()
        ];

        // Uppdatera session
        $session->set("decOfCards", $decOfCards);
        
        return $this->render("cards/single_card.html.twig", $data);
    }
}