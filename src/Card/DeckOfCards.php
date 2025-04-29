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
     * @var array<mixed>
     */
    private array $jsonCards = [];

    /**
     * Array holding an array of CardGraphic objects
     * @var array<CardGraphic>
     */
    private array $graphicCards = [];

    /**
     * Array with strings representing the color of a card
     * @var array<string>
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
    public function generateDeck(): void
    {
        sort($this->familys);
        foreach ($this->familys as $family) {
            foreach (self::STRINGVALUES as $string) {
                $card = new CardGraphic($family["name"], $family["color"], $string);
                $this->jsonCards[] = [
                    "card" => $card,
                    "color" => $card->getCardFamily(),
                    "stringValue" => $card->getCardStringValue(),
                    "symbol" => $card->getSymbol(),
                    "graphicColor" => $card->getCardGraphicColor(),
                ];
            }
        }
    }

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
     * @return void
     */
    public function shuffleGraphic(): void
    {
        shuffle($this->graphicCards);
    }

    /**
     * Shuffle the list of cards,
     * @return void
     */
    public function shuffleCards(): void
    {
        shuffle($this->jsonCards);
    }

    /**
     * Return all jsonCardObjects
     * @return array<mixed>
     */
    public function getCards()
    {
        return $this->jsonCards;
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
     * Function to draw a card from the list of cards.
     * If @param $num, draw $num of cards.
     * always removes the cards from "top-to-bottom".
     * The list of cards is updated directly.
     * Return assosciavtive array ("card": GraphicCard object, "symbol", utf-8 symbol,
     * "value": intValue, "stringValue": value as string, ess, knekt etc)
     *
     * @return array<mixed> with card objects which was removed from the list
     */
    public function draw(?int $num = 1): array
    {
        $removedCards = array_splice($this->jsonCards, -$num);
        return $removedCards;
    }

    /**
     * Function to draw a card from the array of graphicCards.
     * If @param $num, draw $num of cards.
     * always removes the cards from "top-to-bottom".
     * The array of cards is updated at place.
     * @return CardGraphic object
     */
    public function drawGraphic(): CardGraphic
    {
        $removedCards = array_pop($this->graphicCards);
        return $removedCards;
    }

    /**
     * Count the number of cards
     */
    public function countCards(): int
    {
        return count($this->jsonCards);
    }

    /**
     * Count the number of cards
     */
    public function countGraphicCards(): int
    {
        return count($this->graphicCards);
    }
}
