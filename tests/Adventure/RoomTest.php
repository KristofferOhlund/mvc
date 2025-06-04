<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;

class RoomTest extends TestCase
{
    /**
     * Assert Item instance
     */
    public function testCreateInstance()
    {
        $room = new Room("graveyard");
        $this->assertInstanceOf(Room::class, $room);
    }

    /**
     * Assert get Name returns name with first letter upper case
     *
     */
    public function testGetRoomImg()
    {
        $room = new Room("graveyard");
        $room->setImg("graveyard.png");
        $this->assertSame("graveyard.png", $room->getImg());
    }

    /**
     * Assert addGetItems
     */
    public function testAddGetItems()
    {
        $room = new Room("graveyard");
        $item = new Item("coing", "coing.png");
        $item2 = new Item("skull", "skull.png");
        $room->addItem($item);
        $room->addItem($item2);

        $this->assertCount(2, $room->getItems());
    }


}
