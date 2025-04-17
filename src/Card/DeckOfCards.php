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
    private array $jsonCards = [];

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
     * Generate a new deck of cards.
     * Each element in the array is an object of CardGraphic: Card.
     * Each element containts of [
     *  "card" => card object,
     *  "color" => Color of the card, hjärter, klöver,
     *  "stringValue" => "11", "dam" etc
     *  "symbol" utf-8 symbol representing the card
     * ]
     * @return void
     */
    public function generateDeckJson(): void
    {
        sort($this->colors);
        foreach ($this->colors as $color) {
            foreach (self::STRINGVALUES as $string) {
                $card = new CardGraphic($color, $string);
                $this->jsonCards[] = [
                    "card" => $card,
                    "color" => $card->getCardColor(),
                    "stringValue" => $card->getCardStringValue(),
                    "symbol" => $card->getSymbol(),
                ];
            }
        }
    }


    /**
     * Shuffle the list of cards,
     * @return true
     */
    public function shuffleCardsJson()
    {
        shuffle($this->jsonCards);
    }

    /**
     * Return all jsonCardObjects
     */
    public function getJsonCards()
    {
        return $this->jsonCards;
    }

    /**
     * Function to draw a card from the list of cards.
     * If @param $num, draw $num of cards.
     * always removes the cards from "top-to-bottom".
     * The list of cards is updated directly.
     *
     * @return array with card objects which was removed from the list
     */
    public function drawJson(?int $num = 1): array
    {
        $removedCards = array_splice($this->jsonCards, -$num);
        return $removedCards;
    }

    /**
     * Count the number of cards
     */
    public function countCardsJson(): int
    {
        return count($this->jsonCards);
    }
}
