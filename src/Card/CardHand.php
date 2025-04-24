<?php

/**
 * Representing a hand of Cards.
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

    /**
     * Add a CardGraphic Object to the list of cards
     * @return void
     */
    public function addCard(CardGraphic $card): void
    {
        array_push($this->cards, $card);
    }

    /**
     * Get all card symbols for current hand
     * @return array of Symbols
     */
    public function getCards(): array {
        $symbols = [];
        foreach($this->cards as $card){
            array_push($symbols, $card->getSymbol());
        }
        return $symbols;
    }
}
