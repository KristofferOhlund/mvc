<?php

/**
 * Module for Room Objects
*/
namespace App\Adventure;

use App\Adventure\Room;

class RoomHandler
{
    private array $rooms;
    private int $currentRoom;

    public function __construct() {
        $this->rooms = [];
    }

    /**
     * Add a room Object to the room array
     * @return void
     */
    public function addRoom(Room $room): void {
        $this->rooms[] = $room;
    }

    /**
     * Get all rooms
     * @return array
     */
    public function getAllRooms(): array
    {
        return $this->rooms;
    }

    /**
     * Get the current room
     * 
     * @return Room
     */
    public function getCurrentRoom(): Room
    {   
        if (!$this->currentRoom && count($this->rooms) > 0) {
            return $this->rooms[0];
        } return $this->rooms[$this->currentRoom];        
    }

    public function getPrevious(): int
    {
        return array_search($this->currentRoom, $this->rooms);
    }

    /**
     * Set current room
     * defaults to the first room in rooms array
     * @return bool
     */
    public function setCurrentRoomByName(string $roomName): bool
    {
        foreach($this->rooms as $room) {
            if ($room->getName === $roomName) {
                $this->currentRoom = $room;
                return true;
            }
        } throw new \Exception("There is no room with name: $roomName");
    }

    /**
     * Get Room by name
     * or null if not exists
     *
     * @return Room|null
     */
    public function getRoomByName(string $roomName): ?Room
    {
        foreach($this->rooms as $room) {
            if ($room->getName() === $roomName) {
                return $room;
            }
        } throw new \Exception("There is no room with name: $roomName");
    }

    /**
     * Get the next room
     * @param string $room - room of the current room
     * @return Room
     */
    public function getNextRoom(string $currentRoom) {
        $rooms = $this->getAllRooms();
        for ($idx = 0; $idx <= count($rooms); $idx++) {
            if ($rooms[$idx]->getName() === $currentRoom) {
                return $rooms[$idx +1];
            }
        }
    }
}