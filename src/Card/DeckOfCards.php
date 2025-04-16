<?php

/**
 * Representing an entire Dec of cards.
 */

namespace App\Card;
// use App\Card\Card;
use App\Card\CardGraphic;

class DeckOfCards
{
    /**
     * Array holding card objekts.
     */
    private array $cards = [];

    /**
     * Add a card objekt to the array $cards
     * @return void
     */
    public function add(CardGraphic $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * Shuffle the list of cards,
     * @return true
     */
    public function shuffleCards() {
        shuffle($this->cards);
    }

    /**
     * Function to get a card symbol
     * @return array of card symbols, as utf-8 strings.
     */
    public function getCards():array {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getSymbol();
        }
        return $values;
    }

    /**
     * public function to draw a random card from the list of cards.
     * @return Card card objekt drawn from list
     */
    public function draw() {
        $randomPos = random_int(0, count($this->cards) -1);
        $removedCard = array_splice($this->cards, $randomPos, 1);
        return $removedCard[0];
    }

    /**
     * Count the number of cards
     */
    public function countCards(): int{
        return count($this->cards);
    }
}