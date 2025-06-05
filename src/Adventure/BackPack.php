<?php

namespace App\Adventure;

use App\Adventure\Item;
use Exception;

/**
 * Backpack acts as an Inventory, which allows adding items to its pockets
 * Each item is dropped from the inventory after being interacted with
 * If a player adds and apple and later eats it, the apple is removed from the backpack.
 */
class BackPack
{
    /**
     * @var array<Item> $items
     */
    private array $items = [];

    /**
     * Add a Item objekt to the backpack inventory
     *
     * @return string
     */
    public function addItem(Item $newItem): string
    {
        $this->items[] = $newItem;
        return $newItem->getName() . "added to inventory";
    }

    /**
     * Drop Item item from backpack
     * @param Item $dropItem - item to be dropped
     *
     * @return string
     */
    public function dropItem(Item $dropItem): string
    {
        foreach ($this->items as $index => $item) {
            if ($item->getName() === $dropItem->getName()) {
                unset($this->items[$index]);
                $this->items = array_values($this->items);
                return $dropItem->getName() . "dropped from backpack";
            }
        }
        $name = $dropItem->getName();
        throw new Exception("There is no item with name: $name in inventory");
    }

    /**
     * Return all items in backpack
     *
     * @return array<Item> of items in backpack
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Return the item by name, or null if it doesnt exists
     * @param string $itemName the name of the item to get
     * @return Item|null
     */
    public function getItemByName(string $itemName): ?Item
    {
        foreach ($this->items as $item) {
            if ($item->getName() == $itemName) {
                return $item;
            }
        }
        return null;
    }
}
