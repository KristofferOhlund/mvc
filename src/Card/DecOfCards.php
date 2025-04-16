<?php

/**
 * Representing an entire Dec of cards.
 */

namespace App\Card;
use App\Card\Card;

class DecOfCards
{
    /**
     * Array holding card objekts.
     */
    private array $cards = [];

    /**
     * Add a card objekt to the array $cards
     * @return void
     */
    public function add(Card $card): void
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
     * Returns the list of cards as strings
     */
    public function getCards() {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getAsString($card->getCardName(), $card->getCardValue());
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
        return $removedCard;
    }

    /**
     * Count the number of cards
     */
    public function countCards(): int{
        return count($this->cards);
    }
}