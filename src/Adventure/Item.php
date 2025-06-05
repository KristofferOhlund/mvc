<?php

namespace App\Adventure;

/**
 * Class representing an Item, acts as parent to Weapon and Food
 */
class Item
{
    private string $name;
    private string $icon;

    public function __construct(string $name, string $icon)
    {
        $this->name = $name;
        $this->icon = $icon;
    }

    /**
     * Get the name of the item
     *
     * @return string
     */
    public function getName(): string
    {
        return ucfirst($this->name);
    }

    /**
     * Get the icon as string
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }
}
