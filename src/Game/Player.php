<?php

/**
 * Card class, representing a card in Card game
 */

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\CardHand;
use app\Card\DeckOfCards;

class Player
{
    /**
     * The name of the player
     * Can be implemented to set a specific name
     */
    private string $name;

    /**
     * Player points
     * Points gets added from the Cardhand
     */
    private int $points;

    /**
     * Bool representing wheter a player
     * wants to draw another card.
     * Defaults to true,
     * when false player round is done.
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
        $this->points = 0;
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
     * Get the current state of daredevil
     * @return bool
     */
    public function getStop(): bool
    {
        return $this->stop;
    }

    /**
     * Return all card objects in hand
     * @return array<GraphicCard>
     */
    public function showHand(): array
    {
        return $this->cardhand->getCardsInHand();
    }

    /**
     * Return all card symbols in hand
     * @return array<string> utf-8 symbol
     */
    public function showSymbolsInHand(): array {
        return $this->cardhand->getCardSymbols();
    }

    /**
     * Return the name of the player
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Add points to the player
     */
    public function addPoints(int $points)
    {
        $this->points += $points;
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
     * @return CardGraphic Card drawn from deck
     */
    public function drawCard(DeckOfCards $cardDeck): CardGraphic
    {
        $card = $cardDeck->drawGraphic();
        return $card;
    }

    /**
     * Get the points of the players card hand
     */
    public function getPoints()
    {
        return $this->cardhand->getPointsOfHand();
    }

    /**
     * Show a Json representation of the Player
     * 
     */
    public function getPlayerRepresentation() {
        $jsonObject = [];
        foreach($this->showHand() as $card) {
            $jsonObject[] = [
                "card" => $card->getCardFamily(),
                "string" => $card->getCardStringValue(),
                "points" => $card->getCardValue(),
                "symbol" => $card->getSymbol()
            ];
        }
        return $jsonObject;
    }
}
