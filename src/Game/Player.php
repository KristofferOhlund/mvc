<?php

/**
 * Card class, representing a card in Card game
 */

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

class Player
{
    /**
     * The name of the player
     * Can be implemented to set a specific name
     */
    private ?string $name;

    /**
     * Bool representing wheter a player
     * wants to stop the current round.
     * Defaults to false
     * When set to true, player is done.
     */
    private bool $stop;

    protected CardHand $cardhand;

    /**
     * Constructor
     * set name to name if any
     * Initialize a new DiceHand object
     */
    public function __construct(?string $name = "player")
    {
        $this->name = $name;
        $this->cardhand = new CardHand();
        $this->stop = false;
    }

    /**
     * Stop the round
     * @return void
     */
    public function stop(): void
    {
        $this->stop = true;
    }

    /**
     * Get the class of this->cardhand
     * @return string - the name of the class
     */
    public function getCardHandClass()
    {
        return get_class($this->cardhand);
    }

    /**
     * Get the current state of daredevil
     * @return bool
     */
    public function hasStop(): bool
    {
        return $this->stop;
    }

    /**
     * Return all card objects in hand
     * @return array<CardGraphic>
     */
    public function showHand(): array
    {
        return $this->cardhand->getCardsInHand();
    }

    /**
     * Return all card symbols in hand
     * @return array<string> utf-8 symbol
     */
    public function showSymbolsInHand(): array
    {
        return $this->cardhand->getCardSymbols();
    }

    /**
     * Return the name of the player
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * Add a CardGraphic object to the card hand
     * @return void
     */
    public function addCard(CardGraphic $card): void
    {
        $this->cardhand->addCard($card);
    }

    /**
     * Draw a card from DeckOfCards object
     * @return CardGraphic object drawn from deck
     */
    public function drawCard(DeckOfCards $cardDeck): CardGraphic
    {
        $card = $cardDeck->drawGraphic();
        return $card;
    }

    /**
     * Get the points of the players card hand
     * @return int
     */
    public function getPoints(): int
    {
        return $this->cardhand->getPointsOfHand();
    }

    /**
     * Show a Json-like representation of the Player cards.
     * Showing each cards family, name, value and symbol
     * @return list<array<string, int|string>>
     */
    public function getPlayerRepresentation(): array
    {
        $array = [];
        foreach ($this->showHand() as $card) {
            $array[] = $card->getCardGraphicPresentation();
        }
        return $array;
    }
}
