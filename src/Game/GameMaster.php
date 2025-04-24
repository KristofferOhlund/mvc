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
     * Constructor, keeping all players of the game
     */
    private array $players;

    /**
     * Private queue, keeping track of whos turn it is
     * 
     */
    private array $queue;


    public function __construct(Player $player, Bank $bank)
    {
        $this->players = [$player, $bank];
        $this->queue = array_slice($this->players, 0, count($this->players));
    }

    /**
     * Return the current player in Queue
     * Raise error if Queue is empty
     */
    public function peek() {
        if ($this->getSize()) {
            return $this->queue[0];
        }
    }

    /**
     * Get the size of the queue array
     * @return int - the size of the queue stack
     */
    public function getSize():int {
        return count($this->queue);
    }

    /**
     * Dequeue
     * @return Player object
     */
    public function dequeue(): Player {
        return array_shift($this->queue);
    }

    /**
     * Enqueue a player object
     * Appends to the end of the queue
     */
    public function enqueue(Player $player): void {
        array_push($this->queue, $player);
    }

    /**
     * Declare the winner
     * Comparing points between Player objects
     */
    public function getWinner() {
        $winner = null;
        $max = 0;
        for ($i = 0; $i < count($this->players); $i++) {
            $playerPoints = $this->players[$i]->getPoints();
            if ( $playerPoints > $max) {
                $max = $playerPoints;
                $winner = $this->players[$i];
            } 
        }
        return $winner;
    }

    /**
     * Controlls wheter all players daredevil are set to false
     * @return bool
     */
    public function checkGameStop(): bool {
        return array_all($this->players, function(Player $player) {
            return $player->getStop();
        });
    }
    
}