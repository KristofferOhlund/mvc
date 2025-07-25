<?php

namespace App\Adventure;

use App\Adventure\Item;

/**
 * Class representing a Room object.
 * The representation is an background image.
 * Each Room can have an array of items
 */
class Room
{
    /**
     * @var string|null $roomImg
     *
     * A path for the img
     * Img has to be found in assets
     */
    private ?string $roomImg;

    /**
     * Items in room
     * @var array<Item>
     */
    private array $roomItems;

    /**
     * The name of the room
     * @var string $name
     */
    private string $name;

    public function __construct(string $roomName)
    {
        $this->name = $roomName;
        $this->roomImg = null;
        $this->roomItems = [];
    }

    /**
     * Get the name of the room
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set a img representing a room
     *
     * @return void
     */
    public function setImg(string $img): void
    {
        $this->roomImg = $img;
    }

    /**
     * Return the img of the room
     * or null if no img is set
     *
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->roomImg;
    }

    /**
     * Add an item for the room
     *
     * @return string
     */
    public function addItem(Item $item): string
    {
        $this->roomItems[] = $item;
        return $item->getName() . " added to the room";
    }

    /**
     * Get all items in room
     *
     * @return array<Item|null>
     */
    public function getItems(): ?array
    {
        return $this->roomItems;
    }
}
