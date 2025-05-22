<?php

namespace App\Adventure;

use App\Adventure\Varelse;
use App\Adventure\BackPack;

class Human extends Varelse
{   
    private ?Weapon $weapon;
    private ?BackPack $backpack = null;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->weapon = null;
    }

    public function equipBackPack(?BackPack $backPack): ?BackPack 
    {
        $this->backpack = $backPack;
        return $this->backpack ?? null;
    }

    public function addWeapon(Weapon $weapon) {
        $this->weapon = $weapon;
    }

    /**
     * Eat Food
     * Increase health by Food healing value
     * @return void
     */
    public function eatFood(Food $foodItem): int {
        $this->increaseHealth($foodItem->getHealingValue());
        return $this->getHealth();
    }

    public function getItemsInBag(): ?array {
        return $this->backpack->getItems();
    }

    /**
     * Use a weapon, causing dmg equal to baseattackpower + weapon dmg
     */
    public function attackWithWeapon() {
        return $this->getAttackPower() + ($this->weapon?->getWeaponDmg() ?? 0);
    }
}