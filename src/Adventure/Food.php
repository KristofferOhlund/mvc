<?php

namespace App\Adventure;

use App\Adventure\Item;

class Food extends Item
{   
    private int $healingValue = 0;

    public function __construct(string $name, int $healingValue, string $icon)
    {
        parent::__construct($name);
        parent::__construct($icon);
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