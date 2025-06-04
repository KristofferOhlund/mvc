<?php

namespace App\Adventure;

/**
 * Module for getting an events text msg
 * If an item is looted, adds a text msg saying something about that loot
 */

use Exception;

class DialogHandler
{
    /**
     * The name of the current room
     * @var string $room
     */
    private ?string $room;

    /**
     * The name of the currently looted item
     * @var string $item
     */
    private ?string $item;

    /**
     * Each Room has items, each items is a key for a msg
     * @var array<string, array<string, string>> $roomMsgByStatus
     */
    private array $roomMsgByStatus = [
        "graveyard" => [
            "Shovel" => "A rusty shovel, maybe i can dig up some secrets..",
            "Coin" => "A golden coin, looks ancient",
            "Tooth" => "A tooth, maybe i can put it under my pillow.",
            "Sword" => "A fine sword, still sharp!",
            "Key" => "Look a golden Key, i wonder what door it might unlock"
        ],
        "apple" => [
            "Apple" => "This apple looks almost magical, maybe i can use it later"
        ],
        "dragon" => [
            "Sharp bone" => "Maybe i can increase the dmg with this sharp bone"
        ]

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
        if ($this->room) {
            return $this->roomMsgByStatus[$this->room][$this->item];
        }
        return "";
    }

    /**
     * Set current room
     *
     * @return string
     */
    public function setCurrentRoom(string $room): string
    {
        $this->room = $room;
        return $room;
    }


    /**
     * Set currently looted item
     *
     * @return string
     */
    public function setCurrentItem(string $item): string
    {
        $this->item = $item;
        return $item;
    }


    /**
     * Get the current room
     *
     * @return null|string
     */
    public function getCurrentRoom(): ?string
    {
        return $this->room;
    }


    /**
     * Get the current item
     *
     * @return null|string
     */
    public function getCurrentItem(): ?string
    {
        return $this->item;
    }
}
