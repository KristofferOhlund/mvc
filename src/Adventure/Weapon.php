<?php

namespace App\Adventure;

use App\Adventure\Item;

class Weapon extends Item
{
    private int $dmg;

    public function __construct(string $name, int $dmg)
    {
        parent::__construct($name);
        $this->dmg = $dmg;
    }

    public function getWeaponDmg() {
        return $this->dmg;
    }
}