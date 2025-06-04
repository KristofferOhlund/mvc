<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;

class TestItem extends TestCase
{
    /**
     * Assert Item instance
     */
    public function testCreateInstance()
    {
        $item = new Item("Gold coin", "coin.png");
        $this->assertInstanceOf(item::class, $item);
    }

    /**
     * Assert get Name returns name with first letter upper case
     *
     */
    public function testGetNameTitleCase()
    {
        $item = new Item("gold coin", "coin.png");
        $name = $item->getName();
        $this->assertSame("Gold coin", $name);
    }


}
