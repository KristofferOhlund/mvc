<?php

/**
 * GameMaster class, representing the judge / rule controller of the game
 * GameMaster keeps tracks of turns in queue
 * GameMaster defines the winner
 */

namespace App\Game;

class GameMaster
{
    /**
     * The bank acts as a player but is
     * controlled by the GameMaster
     * @var Bank|null
     */
    private ?Bank $bank;

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
     * Constructor
     * Play multiple players or with bank
     */
    public function __construct(Player $player, ?Bank $bank = null)
    {
        $this->bank = $bank;
        // $this->players = [$player, $bank];
        // $this->players = [$player, $this->bank];
        $this->players = [$player];
        $this->queue = array_slice($this->players, 0, count($this->players));
    }

    /**
     * NOT IMPLEMENTED
     * USE IF MULTIPLAYER
     * Add players to the game
     * @param Player $player
     * @return void
     */
    public function addPlayer(Player $player): void
    {
        array_push($this->players, $player);
        $this->queue = array_slice($this->players, 0, count($this->players));
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
     * Get the size of the queue array
     * @return int - the size of the queue stack
     */
    public function getSize(): int
    {
        return count($this->queue);
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
     * Declare winner
     * If player.points > 21, bank wins
     * If bank.points > 21, player wins
     * If both.points < 21, highest points wins.
     * @return array<string, Player|null>
     */
    public function declareWinner(): array
    {
        $winner = $this->bank;
        $looser = $this->players[0];
        $bankPoints = 0;
        $playerPoints = 0;

        if ($this->bank) {
            $bankPoints = $this->bank->getPoints();
        }

        if ($this->players) {
            $playerPoints = $this->players[0]->getPoints();
        }


        if ($playerPoints > 21) {
            $winner = $this->bank;
            $looser = $this->players[0];
        } elseif ($playerPoints == $bankPoints) {
            $winner = $this->bank;
            $looser = $this->players[0];
        } elseif ($playerPoints > $bankPoints) {
            $winner = $this->players[0];
            $looser = $this->bank;
        } elseif ($bankPoints > 21) {
            $winner = $this->players[0];
            $looser = $this->bank;
        }

        return ["winner" => $winner, "looser" => $looser];
    }

    /**
     * Declare the winner
     * Comparing points between Player objects
     * Method is suitable if multiple real players
     * @return Player|null
     */
    public function getWinner(): ?Player
    {
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
    public function checkGameStop(): bool
    {
        return array_all($this->players, function (Player $player) {
            return $player->getStop();
        });
    }
}
