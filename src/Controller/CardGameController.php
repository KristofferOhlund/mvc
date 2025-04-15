<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
// use App\Card\Card;
// use App\Card\CardGraphic;
// use App\Card\CardHand;
// use App\Card\DecOfCards;

class CardGameController extends AbstractController
{
    #[Route("/session", name:"session_dump")]
    public function session(SessionInterface $session): Response
    {
        $data = [
            "session_dump" => ""
        ];

        return $this->render("cards/session.html.twig", $data);
    }

    #[Route("/card", name:"card")]
    public function card(): Response
    {
        return $this->render("cards/card.html.twig");
    }

    #[Route("/card/deck", name:"card_deck")]
    public function cardDeck(): Response
    {
        return $this->render("cards/card_deck.html.twig");
    }

    #[Route("/card/deck/shuffle", name:"card_deck_shuffle")]
    public function cardDeckShuffle(): Response
    {
        return $this->redirectToRoute("card_deck");
    }
}