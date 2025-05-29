<?php

namespace App\Adventure;

use App\Adventure\Item;
use Exception;

class BackPack
{
    private array $items = [];

    public function AddItem(Item $newItem) {
        $this->items[] = $newItem;
    }

    /**
     * Drop Item item from backpack
     * @param Item $dropItem - item to be dropped
     */
    public function dropItem(Item $dropItem)
    {
        foreach($this->items as $index => $item) {
            if ($item->getName() === $dropItem->getName()) {
                unset($this->items[$index]);
                $this->items = array_values($this->items);
                return;
            }
        }
        $name = $dropItem->getName();
        throw new Exception("There is not food with name: $name");
    }

    /**
     * Return all items in backpack
     * 
     * @return array of items in backpack
     */
    public function getItems(): ?array {
        return $this->items;
    }

    /**
     * Return the item by name, or null if it doesnt exists
     * @param string $itemName the name of the item to get
     * @return Item|null
     */
    public function getItemByName(string $itemName): ?Item {
        foreach($this->items as $item) {
            if ($item->getName() == $itemName) {
                return $item;
            }
        }
        return null;
    }
}