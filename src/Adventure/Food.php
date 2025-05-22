<?php

namespace App\Adventure;

use App\Adventure\Item;

class Food extends Item
{   
    private int $healingValue = 0;

    public function __construct(string $name, int $healingValue)
    {
        parent::__construct($name);
        $this->healingValue = $healingValue;
    }

    /**
     * Get the healing value from food
     * 
     * @return int healingValue
     */
    public function getHealingValue(): int {
        return $this->healingValue;
    }
}