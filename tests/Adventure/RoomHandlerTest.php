<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TestRoomHandler extends TestCase
{
    /**
     * Verify instance of RoomHandler
     */
    public function testInstanceOf()
    {
        $roomHandler = new RoomHandler();
        $this->assertInstanceOf(RoomHandler::class, $roomHandler);
    }

    /**
     * Verify AllRooms return the correct number of rooms
     */
    public function testGetAllRooms()
    {
        $rooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        $roomHandler = new RoomHandler();

        foreach ($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $roomNames = $roomHandler->getAllRoomNames();
        $this->assertSame($roomNames, $rooms);
        $this->assertCount(4, $roomHandler->getAllRooms());
    }

    /**
     * Assert getRoombyName Exception
     */
    public function testGetRoomByNameException()
    {
        $this->expectExceptionMessage("There is no room with name: graveyard");
        $roomHandler = new RoomHandler();
        $roomHandler->getRoomByName("graveyard");
    }

    /** 
     * Test that each room returns correct room
     */
    public function testGetNext()
    {
        $rooms = [
                    "graveyard", "house", "apple", "dragon"
                ];
        
        $roomHandler = new RoomHandler();

        foreach ($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $nextRoom = $roomHandler->getNext("apple");
        $this->assertSame($nextRoom, "dragon");
        $nextRoom = $roomHandler->getNext("dragon");
        $this->assertSame($nextRoom, "dragon");
        
        $roomHandler = new RoomHandler();
        $this->assertSame("No rooms", $roomHandler->getNext("dragon"));
    }


    /** 
     * Test that each room returns correct room
     */
    public function testGetPrev()
    {
        $rooms = [
                    "graveyard", "house", "apple", "dragon", "mango"
                ];
        
        $roomHandler = new RoomHandler();

        foreach ($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $nextRoom = $roomHandler->getPrev("apple");
        $this->assertSame($nextRoom, "house");
        $nextRoom = $roomHandler->getPrev("graveyard");
        $this->assertSame($nextRoom, "graveyard");
        
        $roomHandler = new RoomHandler();
        $this->assertSame("No rooms", $roomHandler->getPrev("dragon"));
    }


    /**
     * Test addItemToRoom
     */
    public function testaddItemToRoom()
    {

        $room = new Room("graveyard");
        $roomHandler = new RoomHandler();
        $roomHandler->addRoom($room);
        $item = new Item("key", "key.png");
        $status = $roomHandler->addItemToRoom($room->getName(), $item);

        $this->assertSame("Key added to the room", $status);
    }

    /**
     *
     * Test addItemToRoom
     */
    public function testaddItemToRoomNotExist()
    {

        $room = new Room("graveyard");
        $roomHandler = new RoomHandler();
        $roomHandler->addRoom($room);

        $item = new Item("key", "key.png");
        $this->expectExceptionMessage("There is no room with name: invalid");
        $roomHandler->addItemToRoom("invalid", $item);
    }
}
