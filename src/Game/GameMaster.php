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
     * Comparing points between two Player objects
     */
    public function declareWinner() {
        $player1 = $this->players[0];
        $player2 = $this->players[1];
        $winner = $player1->points > $player2->points ? $player1->getName() : $player2->getName();
        return $winner; 
    }
    
}

// """ Queue module """

// class Queue:
//     """ Queue class """
//     def __init__(self, data=None):
//         self._items = data or []

//     def is_empty(self):
//         """ If queue is empty, return True, else False"""
//         if not self._items:
//             return True
//         return False

//     def enqueue(self, item):
//         """ add to queue """
//         self._items.append(item)

//     def dequeue(self):
//         """ Remove queue """
//         try:
//             return self._items.pop(0)

//         except IndexError:
//             return "Empty list."

//     def peek(self):
//         """ Peek to see who's next """
//         return self._items[0]

//     def size(self):
//         """ Return the len of items"""
//         return len(self._items)

//     def to_list(self):
//         """ Return queue as list """
//         queue = []
//         for player in self._items:
//             queue.append(player)
//         return queue


//     @classmethod
//     def from_session(cls, data):
//         """ Create a queue instance from current data """
//         return cls(data)