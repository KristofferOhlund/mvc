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

    /**
     * Add an item to the backpack
     * @param Item item to be added to the backpack
     * @return true
     */
    public function addItemToBackPack(Item $item): bool {
        if ($this->backpack) {
            $this->backpack->AddItem($item);
            return true;
        } return false;
    }

    /**
     * Add a weapon object to the human
     * @param Weapon $weapon - Weapon to be equipped
     * @return void
     */
    public function addWeapon(Weapon $weapon): void {
        $this->weapon = $weapon;
    }

    /** 
     * Get the weapon objects name
     * 
     * @return string the name of the weapon
     */
    public function getWeaponName(): string {
        return ucfirst($this->weapon?->getName() ?? "");
    }

    /**
     * Eat Food
     * Increase health by Food healing value
     * @return int
     */
    public function eatFood(Food $foodItem): int {
        $this->increaseHealth($foodItem->getHealingValue());
        $backPack = $this->backpack;
        $backPack->dropItem($foodItem);
        return $this->getHealth();
    }

    /**
     * @return null|array
     */
    public function getItemsInBag(): ?array {
        return $this->backpack?->getItems();
    }

    /**
     * Use a weapon, causing dmg equal to baseattackpower + weapon dmg
     * @return int total dmg caused by attack
     */
    public function attackWithWeapon(): int {
        return $this->getAttackPower() + ($this->weapon?->getWeaponDmg() ?? 0);
    }

    /**
     * Get an item from your backpack
     * @return Food
     */
    public function getItemByName(string $name)
    {   
        foreach($this->getItemsInBag() as $food) {
            if ($food->getName() === $name) {
                return $food;
            }
        } throw new \Exception("There is no food with name: $name");
    }
}