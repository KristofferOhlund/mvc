<?php

namespace App\Adventure;

use App\Adventure\Item;

/**
 * Class representing as a weapon, extending Item
 * The weapon can be equipped by a Human
 */
class Weapon extends Item
{
    private int $dmg = 0;

    public function __construct(string $name, int $dmg, string $icon)
    {
        parent::__construct($name, $icon);

        $this->dmg = $dmg;
    }

    /**
     * Get the dmg caused by the weapon
     *
     * @return int
     */
    public function getWeaponDmg(): int
    {
        return $this->dmg;
    }
}
