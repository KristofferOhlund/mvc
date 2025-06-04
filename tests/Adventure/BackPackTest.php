<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;

class TestBackPack extends TestCase
{
    /**
     * Create instance of BackPack
     */
    public function testBackPackInstance()
    {
        $backpack = new BackPack();
        $this->assertInstanceOf(BackPack::class, $backpack);
    }

    /**
     * Add a item to the backpack
     */
    public function testBackPackaddItem()
    {
        $item = new Food("Apple", 50, "apple.png");
        $backpack = new BackPack();
        $backpack->addItem($item);

        $items = $backpack->getItems();
        $this->assertCount(1, $items);
    }

    /**
     * Get item object by name
     */
    public function testBackPackGetItemByName()
    {
        $food = new Food("Apple", 50, "apple.png");
        $backpack = new BackPack();
        $backpack->addItem($food);
        $name = $backpack->getItemByName("Apple");

        $this->assertEquals($food, $name);
    }

    /**
     * Test missing item, return null
     */
    public function testBackPackGetItemByMissingName()
    {
        $backpack = new BackPack();
        $name = $backpack->getItemByName("Apple");

        $this->assertNull($name, "Backpack har inget Apple");
    }
}
