<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TestRoomHandler extends TestCase
{   
    /**
     * Verify instance of RoomHandler
     */
    public function testInstanceOf() {
        $roomHandler = new RoomHandler();
        $this->assertInstanceOf(RoomHandler::class, $roomHandler);
    }

    /**
     * Verify AllRooms return the correct number of rooms
     */
    public function testGetAllRooms(){
        $rooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        $roomHandler = new RoomHandler();
        
        foreach($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $this->assertCount(4, $roomHandler->getAllRooms());
    }

    /**
     * Verify that getAllRoomNames returns all the names of the rooms
     */
    public function getAllRoomNames() {
        $rooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        $roomHandler = new RoomHandler();
        
        foreach($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $roomNames = $roomHandler->getAllRoomNames();
        $this->assertSame($roomNames, $rooms);
    }

    /**
     * Assert getRoombyName
     */
    public function testGetRoomByName()
    {
        $roomHandler = new RoomHandler();
        $graveyard = new Room("graveyard");
        $dragon = new Room("dragon");
        $roomHandler->addRoom($graveyard);
        $roomHandler->addRoom($dragon);
        
        $returned = $roomHandler->getRoomByName("graveyard")->getname();
        $this->assertSame("graveyard", $returned);
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
     * Test that each rooms returns the correct next room
     */
    public function testGetNext() {
        $rooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        $roomHandler = new RoomHandler();
        
        foreach($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $nextRoom = $roomHandler->getNext("apple");
        $this->assertSame($nextRoom, "dragon");
    }

    /**
     * Test that each rooms returns the correct previous room
     * If current room is the first  room, previous room should point at it self
     */
    public function testGetPrevFirst() {
        $rooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        $roomHandler = new RoomHandler();
        
        foreach($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $nextRoom = $roomHandler->getPrev("graveyard");
        $this->assertSame($nextRoom, "graveyard");
    }

    /**
     * Test to return the previous room
     */
    public function testGetPrevNotFirst() {
        $rooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        $roomHandler = new RoomHandler();
        
        foreach($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $nextRoom = $roomHandler->getPrev("house");
        $this->assertSame($nextRoom, "graveyard");
    }

    /**
     * Test to return the previous room
     */
    public function testGetNextWhenLast() {
        $rooms = [
            "graveyard", "house", "apple", "dragon"
        ];

        $roomHandler = new RoomHandler();
        
        foreach($rooms as $room) {
            /**
             * @var Room|PHPUnit\Framework\MockObject\MockObject $roomObj;
             */
            $roomObj = new Room($room);
            $roomHandler->addRoom($roomObj);
        }

        $nextRoom = $roomHandler->getNext("dragon");
        $this->assertSame($nextRoom, "dragon");
    }
    
}