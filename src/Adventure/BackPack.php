<?php

namespace App\Adventure;

use App\Adventure\Item;

class BackPack
{
    private array $items = [];

    public function AddItem(Item $newItem) {
        $this->items[] = $newItem;
    }

    public function getItems(): ?array {
        return $this->items;
    }

    /**
     * Return the item by name, or null if it doesnt exists
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