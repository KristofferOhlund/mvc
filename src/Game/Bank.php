<?php

/**
 * Bank class inhereting from Player, representing a Bank in Card game
 */

namespace App\Game;

use App\Card\DeckOfCards;

class Bank extends Player
{
    /**
     * Constructor
     * Calling parent constructor - Player
     * Set name to Bank
     */
    public function __construct(?string $name = "Bank")
    {
        parent::__construct($name);
    }


    /**
     * Draw a card from the deck of cards object
     * @return void
     */
    public function bankDrawCard(DeckOfCards $cardDeck): void
    {
        $points = 0;
        while ($points < 17) {
            $card = $this->drawCard($cardDeck);
            $this->addCard($card);
            $points = $this->getPoints();
        }
        $this->stop();
    }
}
