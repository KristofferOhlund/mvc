<?php

/**
 * Card class, representing a card in Card game
 */

namespace App\Card;

class Card
{
    private ?string $value = null;
    private ?string $name = null;

    /**
     * Constructior, initiating a card object.
     * Card Value must be above 1
     */
    public function __construct(?string $cardValue=null, ?string $cardName = null)
    {
        $this->value = $cardValue;
        $this->name = $cardName;
    }

    /**
     * returns the value of the card as int
     * 
     */
    public function getCardValue():string {
        return $this->value;
    }

    /**
     * returns the value of the card as int
     * 
     */
    public function getCardName():string {
        return $this->name;
    }

    /**
     * Function to return the name of the card, 
     * aka hjärter, ess, dam etc
     */
    // public function getAsString(): string
    // {
    //     return $this->name ;
    // }
    // public function getAsString(): string
    // {
    //     return "[{$this->name}]";
    // }
}