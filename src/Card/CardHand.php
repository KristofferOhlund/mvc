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
    public function getCardSymbols(): array
    {
        $symbols = [];
        foreach ($this->cards as $card) {
            array_push($symbols, $card->getSymbol());
        }
        return $symbols;
    }

    /**
     * Get the sum of all int values from cards in hand
     * @return int the Sum of all values
     */
    public function getPointsOfHand(): int
    {
        $points = 0;
        foreach ($this->cards as $card) {
            $points += $card->getCardValue();
        }
        return $points;
    }
}
