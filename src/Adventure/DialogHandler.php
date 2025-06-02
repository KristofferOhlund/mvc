<?php

namespace App\Adventure;

/**
 * Module for getting an events text msg
 * If an item is looted, adds a text msg saying something about that loot
 */

use Exception;

class DialogHandler
{   

    private ?string $room;
    private ?string $item;

    /**
     * Each status has an object mapped
     * Each mapp contains of a text, item and action to perform
     * @var array<int|array> $statusObjects
     */
    private array $roomMsgByStatus = [
        "graveyard" => [
            "Shovel" => "A rusty shovel, maybe i can dig up some secrets..",
            "Coin" => "A golden coin, looks ancient",
            "Tooth" => "A tooth, maybe i can put it under my pillow.",
            "Sword" => "A fine sword, still sharp!",
            "dig" => "Look, a golden key!"
        ],

        ];

    public function __construct()
    {
        $this->room = null;
        $this->item = null;
    }

    /**
     * Get the current statusObjet
     * status represent something that has been looted or an action performed
     * @return string
     */
    public function getDialogByStatus(): string
    {
        if ($this->room)
        {
            return $this->roomMsgByStatus[$this->room][$this->item];
        }
        return "";
    }

    /**
     * Update statusId based on a performed action
     */
    public function setCurrentRoom(string $room)
    {   
        $this->room = $room;
    }

    public function setCurrentItem(string $item)
    {
        $this->item = $item;
    }

    public function getCurrentRoom()
    {
        return $this->room;
    }

    public function getCurrentItem()
    {
        return $this->item;
    }
}