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
    private int $points;

    protected CardHand $cardhand;

    /**
     * Constructor
     * set name to name if any
     * Initialize a new DiceHand object
     */
    public function __construct(?string $name="player")
    {
        $this->name = $name;
        $this->points = 0;
        $this->cardhand = new CardHand();
    }

    /**
     * Return all cardsymbols in hand
     */
    public function showHand() {
        return $this->cardhand->getCardSymbols();
    }

    /**
     * Return the name of the player
     */
    public function getName():string {
        return $this->name;
    }

    /**
     * Get total points of the player
     */
    public function getPoints() {
        return $this->points;
    }

    /**
     * Add points to the player
     */
    public function addPoints(int $points) {
        $this->points += $points;
    }

    /**
     * Add a CardGraphic object to the list of cards
     * @return void
     */
    public function addCard(CardGraphic $card): void {
        $this->cardhand->addCard($card);
    }

    /**
     * Draw a card from DeckOfCards object
     * @return CardGraphic Card drawn from deck
     */
    public function drawCard(DeckOfCards $cardDeck): CardGraphic {
        $card = $cardDeck->drawGraphic();
        return $card;
    }
}