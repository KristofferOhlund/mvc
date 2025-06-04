<?php

/**
 * Module for Room Objects
*/
namespace App\Adventure;

use Exception;
use App\Adventure\Room;

class RoomHandler
{   
    /**
     * Current Rooms in array
     * 
     * @var array<Room>
     */
    private array $rooms;

    public function __construct()
    {
        $this->rooms = [];
    }

    /**
     * Add a room Object to the room array
     * @return void
     */
    public function addRoom(Room $room): void
    {
        $this->rooms[] = $room;
    }

    /**
     * Get all rooms
     * @return array<Room>
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
        return array_map(fn ($room) => $room->getName(), $this->getAllRooms());
    }

    /**
     * Return the next Room in the array
     *
     * @param string $current is the current route, eg adventure/graveyard
     * @return string
     */
    public function getPrev(string $current): string
    {   
        $names = $this->getAllRoomNames();

        // Kontrollera att det verkligen är en array
        if (!is_array($names)) {
            return "No rooms";
        }

        $roomCount = count($names);
        for($idx = 0; $idx < $roomCount +1; $idx++) {
            if ($names[$idx] == $current && $idx > 0) {
                return $this->rooms[$idx -1]->getName();
            } 
            if ($names[$idx] == $current && $idx == 0) {
                return $this->rooms[$idx]->getName();
            }
        }
        return "There is no room with $current as";
    }

    /**
     * Return the next Room in the array, if any
     * else return false
     *
     * @param string $current is the current route, eg adventure/graveyard
     * @return string
     */
    public function getNext(string $current): string
    {
        $names = $this->getAllRoomNames();
        // Kontrollera att det verkligen är en array
        if (!is_array($names)) {
            return "No rooms";
        }

        $roomCount = count($names);
        for($idx = 0; $idx < $roomCount +1; $idx++) {
            if ($names[$idx] == $current && $idx +1 !== count($names)) {
                return $this->rooms[$idx +1]->getName();
            }
            if ($names[$idx] == $current && $idx == $roomCount -1) {
                return $this->rooms[$idx]->getName();    
            }
        }
        return "There is no room with $current as";
    }

    /**
     * Get Room by name
     * or null if not exists
     *
     * @return Room|null
     */
    public function getRoomByName(string $roomName): ?Room
    {
        foreach ($this->rooms as $room) {
            if ($room->getName() === $roomName) {
                return $room;
            }
        } throw new Exception("There is no room with name: $roomName");
    }

    /**
     * Add an Item to a Room
     * @param string $roomName - the room to which an item is added
     * @param Item $item to be added
     * @return string
     */
    public function addItemToRoom(string $roomName, Item $item): string
    {
        $room = $this->getRoomByName($roomName);
        if ($room) {
            return $room->addItem($item);
        }
        return "There is no room with name $roomName";
    }
}
