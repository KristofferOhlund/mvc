<?php

namespace App\Adventure;

use App\Adventure\Item;

class Room
{
    /**
     * @var string|null $roomImg
     * 
     * A path for the img
     * Img has to be found in assets
     */
    private ?string $roomImg;
    private array $roomItems;
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
    public function setImg(string $img): void {
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
     */
    public function addItem(Item $item) {
        $this->roomItems[] = $item;
    }

    /**
     * Get all items in room
     * 
     * @return array<Item|null>
     */
    public function getItems(): ?array {
        return $this->roomItems;
    }
}