<?php

/**
 * Card class, representing a card in Card game
 */

namespace App\Card;

class Card
{
    /**
     * stringValue, aka "11, "knekt" etc
     * Color is type, aka "hjäter, ruter" etc
     */
    private ?string $stringValue;
    private ?string $color;
    private const array CARDVALUES = [
        "2" => 2,
        "3" => 3,
        "4" => 4,
        "5" => 5,
        "6" => 6,
        "7" => 7,
        "8" => 8,
        "9" => 9,
        "10" => 10,
        "knekt" => 11,
        "dam" => 12,
        "kung" => 13,
        "ess" => 14,
    ];

    /**
     * Constructor
     */
    public function __construct(?string $colorValue = null, ?string $valueAsString = null)
    {
        $this->color = $colorValue;
        $this->stringValue = $valueAsString;
    }

    /**
     * Get the string value of the card, aka "11", "knekt"
     * @return string - stringvalue of the card
     */
    public function getCardStringValue(): string
    {
        return $this->stringValue;
    }

    /**
     * Get the value of the card
     * @return int - value of the card, mapped to stringvalue
     */
    public function getCardValue(): int
    {
        return self::CARDVALUES[$this->stringValue];
    }

    /**
     * Get the color of the card
     * @return string of the card color, aka "spader", "ruter", etc
     */
    public function getCardColor(): string
    {
        return $this->color;
    }
}
