<?php

/**
 * GameMaster class, representing the judge / rule controller of the game
 * GameMaster keeps tracks of turns in queue
 * GameMaster defines the winner
 */

namespace App\Game;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class GameMaster
{
    /**
     * The bank acts as a player but is
     * controlled by the GameMaster
     * @var Bank $bank
     */
    private Bank $bank;

    /**
     * Constructor, keeping all players of the game
     * @var array<Player>
     */
    private array $players;

    /**
     * Private queue, keeping track of whos turn it is
     * @var array<Player>
     */
    private array $queue;


    /**
     * Constructor with multiplayer support
     * Set player to players
     * Games always include a bank
     * Add an array of Player objects to this->players
     */
    public function __construct(Player ...$player)
    {
        $this->bank = new Bank();
        $this->players = $player;
        $this->queue = array_slice($this->players, 0, count($this->players));
    }

    /**
     * Return the length of queue
     */
    public function getQueueCount(): ?int
    {
        return count($this->queue);
    }

    /**
     * Get count of players
     */
    public function getPlayerCount(): ?int
    {
        return count($this->players);
    }

    /**
     * Return an array of all players in game
     * @return array<Player>
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * Return the bank object
     */
    public function getBank(): Bank
    {
        return $this->bank;
    }


    /**
     * Return the current player in Queue
     * @return Player|null
     */
    public function peek(): ?Player
    {
        return $this->queue[0];
    }


    /**
     * Dequeue
     * @return Player|null object
     */
    public function dequeue(): ?Player
    {
        return array_shift($this->queue);
    }

    /**
     * Enqueue a player object
     * Appends to the end of the queue
     */
    public function enqueue(Player $player): void
    {
        array_push($this->queue, $player);
    }


    /**
     * Compare the best player vs the bank
     * Return an assosciative array ["winner" => winnerObj, "players" =>
     *  this.players, "bank" => this.bank]
     * @return array<string, Player|array<Player>|null>
     */
    public function declareWinner(): array
    {
        $bestPlayer = $this->getBestPlayer();
        // if player is null
        if (!$bestPlayer) {
            $bestPlayer = new Player();
        }
        $bank = $this->getBank();
        $winner = null;

        if ($bestPlayer->getPoints() > 21) {
            $winner = $bank;
        } elseif ($bank->getPoints() > 21) {
            $winner = $bestPlayer;
        } elseif ($bank->getPoints() == $bestPlayer->getPoints()) {
            $winner = $bank;
        } elseif ($bank->getPoints() > $bestPlayer->getPoints()) {
            $winner = $bank;
        } else {
            $winner = $bestPlayer;
        }

        $result = ["winner" => $winner, "players" => $this->getPlayers(), "bank" => $bank];
        return $result;
    }

    /**
     * Get the player with highest score < 21
     * Comparing points between Player all objects
     * @return Player|null
     */
    private function getBestPlayer(): ?Player
    {
        $pointsToHigh = $this->checkPlayerPointsInvalid();
        if ($pointsToHigh) {
            // get player closest to 21
            return $this->getClosestPlayer();
        }

        $winner = null;
        $max = 0;
        for ($i = 0; $i < count($this->players); $i++) {
            $playerPoints = $this->players[$i]->getPoints();
            if ($playerPoints > $max && $playerPoints < 21) {
                $max = $playerPoints;
                $winner = $this->players[$i];
            }
        }
        return $winner;
    }

    /**
     * Controlls wether all players stop are set to true
     * @return bool
     */
    public function checkPlayersDone(): bool
    {
        return array_all($this->players, function (Player $player) {
            return $player->getStop();
        });
    }

    /**
     * Check if all players have points > 21
     * @return bool
     */
    private function checkPlayerPointsInvalid(): bool
    {
        return array_all($this->players, function (Player $player) {
            return $player->getPoints() > 21;
        });
    }

    /**
     * Get the player who's closest to 21
     * @return Player
     */
    private function getClosestPlayer(): ?Player
    {
        if (count($this->players) > 1) {
            $lowest = array_reduce($this->players, function (?Player $carry, Player $player) {
                return ($carry == null || $player->getPoints() < $carry->getPoints() ? $player : $carry);
            });
            return $lowest;
        } return $this->players[0];
    }
}
