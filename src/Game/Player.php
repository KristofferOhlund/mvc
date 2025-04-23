<?php

/**
 * Card class, representing a card in Card game
 */

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\CardHand;
use app\Card\DeckOfCards;

class Player {

    private string $name;

    private CardHand $cardhand;

    /**
     * Constructor
     * set name to name if any
     * Initialize a new DiceHand object
     */
    public function __construct(?string $name="player")
    {
        $this->name = $name;
        $this->cardhand = new CardHand();
    }

    /**
     * Return all cards in hand
     */
    public function showHand() {
        return $this->cardhand;
    }

    /**
     * Return the name of the player
     */
    public function getName():string {
        return $this->name;
    }

    /**
     * Add cards to hand
     */
    public function addCard(CardGraphic $card) {
        $this->cardhand->addCard($card);
    }

    /**
     * Draw a card from DeckOfCards object
     */
    public function drawCard(DeckOfCards $cardDeck) {
        $this->addCard($cardDeck->draw()[0]);
    }
}