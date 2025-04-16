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
     * Function to draw a card from the list of cards.
     * If @param $num, draw the card at index == num
     * else removes a random card.
     * The list of cards is updated directly.
     * 
     * @return Card card objekt which was removed from the list
     */
    public function draw(?int $num=null): Card {
        if (!$num) {
            $removeIndex = random_int(0, count($this->cards) -1);
        } else {
            $removeIndex = $num -1;
        }

        $removedCard = array_splice($this->cards, $removeIndex, 1);
        return $removedCard[0];
    }

    /**
     * Count the number of cards
     */
    public function countCards(): int{
        return count($this->cards);
    }
}