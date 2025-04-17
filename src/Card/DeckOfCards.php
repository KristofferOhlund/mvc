<?php

/**
 * Representing an entire Dec of cards.
 */

namespace App\Card;
use App\Card\CardGraphic;

class DeckOfCards
{
    /**
     * Array holding card objekts.
     */
    private array $cards = [];

    private array $colors = [
        "spader",
        "hjärter",
        "ruter",
        "klöver",
    ];

    private const array STRINGVALUES = [
        "ess", 
        "2", 
        "3", 
        "4", 
        "5", 
        "6", 
        "7", 
        "8", 
        "9", 
        "10", 
        "knekt", 
        "dam", 
        "kung",
    ];


    /**
     * Generate a new deck of cards
     * @return void
     */
    public function generateDeck(): void {
        sort($this->colors);
        foreach($this->colors as $color) {
            foreach(self::STRINGVALUES as $string) {
                $card = new CardGraphic($color, $string);
                $this->cards[] = $card;
            }
        }
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
     * If @param $num, draw $num of cards.
     * always removes the cards from "top-to-bottom".
     * The list of cards is updated directly.
     * 
     * @return array with card objects which was removed from the list
     */
    public function draw(?int $num=1): array {
        $removedCards = array_splice($this->cards, -$num);
        return $removedCards;
    }

    /**
     * Count the number of cards
     */
    public function countCards(): int{
        return count($this->cards);
    }
}