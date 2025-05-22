<?php

namespace App\Adventure;

use App\Adventure\Item;

class Food extends Item
{
    private int $healingValue;

    public function __construct(string $name, int $healingValue)
    {
        parent::__construct($name);
        $this->healingValue = $healingValue;
    }

    public function getHealingValue() {
        return $this->healingValue;
    }

    public function getFoodName() {
        return $this->getName();
    }
}