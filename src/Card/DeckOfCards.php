<?php

/**
 * Representing an entire Dec of cards.
 */

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    /**
     * Array holding an array of CardGraphic objects
     * @var array<CardGraphic>
     */
    private array $graphicCards = [];

    /**
     * Array with strings representing the color of a card
     * @var array<string, array{name: string, color: string}>
     */
    private array $familys = [
        "spader" => [
            "name" => "spader",
            "color" => "black"
        ],
        "hjärter" => [
            "name" => "hjärter",
            "color" => "red"
        ],
        "ruter" => [
            "name" => "ruter",
            "color" => "red"
        ],
        "klöver" => [
            "name" => "klöver",
            "color" => "black"
        ]
    ];

    /**
     * Array with strings representing the string values of a card
     * @var array<string>
     */
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
        "kung"
    ];


    /**
     * Generate a deck of cards
     * Each element in the deck is a GraphicCard object
     * @return void
     */
    public function generateGraphicDeck(): void
    {
        sort($this->familys);
        foreach ($this->familys as $family) {
            foreach (self::STRINGVALUES as $string) {
                $card = new CardGraphic($family["name"], $family["color"], $string);
                $this->graphicCards[] = $card;
            }
        }
    }

    /**
     * Shuffle the CardGraphic array
     * @param int $num Number of times to shuffle (default: 3)
     * @return void
     */
    public function shuffleGraphic(int $num = 3): void
    {
        for ($i = 0; $i < $num; $i++) {
            shuffle($this->graphicCards);
        }
    }


    /**
     * Return the array of CardGraphic objects
     * @return array<mixed>
     */
    public function getGraphicCards()
    {
        return $this->graphicCards;
    }


    /**
     * Function to draw a card from the array of graphicCards.
     * If @param $num, draw $num of cards.
     * always removes the cards from "top-to-bottom".
     * The array of cards is updated at place.
     * If not num, return a single CardGraphic object
     * If nom, return a array of CardGraphic objects
     * @return mixed with removed cards
     */
    public function drawGraphic(?int $num = null): mixed
    {
        if ($num) {
            return array_splice($this->graphicCards, -$num);
        }
        return array_pop($this->graphicCards);
    }


    /**
     * Count the number of cards
     */
    public function countGraphicCards(): int
    {
        return count($this->graphicCards);
    }

    /**
     * Function to return a json-like presentation for
     * an array of GraphicCards
     * @param array<CardGraphic> $cards
     * @return array<array<string, int|string>>
     */
    public function getArrayOfCardsPresentation(array $cards): array
    {
        $array = [];
        foreach ($cards as $card) {
            $array[] = $card->getCardGraphicPresentation();
        }
        return $array;
    }
}
