<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;

class TestFood extends TestCase
{   
    /**
     * Create instance of Food
     */
    public function testFoodInstance()
    {
        $food = new Food("Apple", 50, "apple.png");
        $this->assertInstanceOf(Food::class, $food);
    }

    public function testGetFoodName() {
        $food = new Food("Burger", 100, "burger.png");
        $this->assertSame("Burger", $food->getName());
    }

    public function testFoodHelingValue() {
        $food = new Food("Apple", 50, "apple.png");
        $healingValue = $food->getHealingValue();

        $this->assertSame(50, $healingValue);
    }
    
}