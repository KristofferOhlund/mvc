<?php

/**
 * Player class, representing a player in Card game
 */

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;

class Bank extends Player {

    /**
     * Constructor
     * Calling parent constructor - Player
     * Set name to Bank
     */
    public function __construct(?string $name="Bank")
    {
        parent::__construct($name);
    }

    /**
     * Draw a card from the deck of cards object
     * @return CardGraphic object
     */
    public function drawCard(DeckOfCards $cardDeck): CardGraphic {
        $card = parent::drawCard($cardDeck);
        return $card;
    }
}