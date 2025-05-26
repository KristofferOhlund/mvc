<?php

namespace App\Adventure;

class Item
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the name of the item
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}