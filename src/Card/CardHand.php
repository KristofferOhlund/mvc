<?php

/**
 * Representing a hand of Cards.
 * Uses composition to create cards in the hand.
 */

namespace App\Card;

use App\Card\CardGraphic;

class CardHand
{
    private array $cards;

    public function __construct()
    {
        $this->cards = [];
    }

    public function addCard(CardGraphic $card)
    {
        $this->cards[] = $card;
    }


}
