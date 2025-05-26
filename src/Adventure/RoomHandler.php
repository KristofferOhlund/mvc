<?php

/**
 * Module for Room Objects
*/
namespace App\Adventure;

use App\Adventure\Room;

class RoomHandler
{
    private array $rooms;

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
     * Get the name of all romes
     * 
     * @return array<string|null>
     */
    public function getAllRoomNames(): ?array
    {
        return array_map(fn($room) => $room->getName(), $this->getAllRooms()) ?? [];
    }

    /**
     * Return the next Room in the array, if any
     * else return false
     * 
     * @param string $current is the current route, eg adventure/graveyard
     * @return string|int|false
     */
    public function getPrev(string $current): ?string
    {
        $currentIndex = array_search($current, $this->getAllRoomNames());
        if ($currentIndex !== 0) {
            return $this->rooms[$currentIndex -1]->getName();
        } return $this->rooms[$currentIndex]->getName();
        
        
    }

    /**
     * Return the next Room in the array, if any
     * else return false
     * 
     * @param string $current is the current route, eg adventure/graveyard
     * @return string|int|false
     */
    public function getNext(string $current): ?string
    {
        $currentIndex = array_search($current, $this->getAllRoomNames());
        if ($currentIndex + 1 !== count($this->rooms))
        {
            return $this->rooms[$currentIndex +1]->getName();
        } return $this->rooms[$currentIndex]->getName();
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
}