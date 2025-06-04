<?php

namespace App\Adventure;

use Exception;
use App\Adventure\Varelse;
use App\Adventure\BackPack;

class Human extends Varelse
{   

    /**
     * Weapon objekt
     * @var Weapon $weapon
     */
    private ?Weapon $weapon;

    /**
     * Backpack objekt, to carry items
     * @var BackPack $backpack
     */
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
     * @param Item $item to be added to the backpack
     * @return string
     */
    public function addItemToBackPack(Item $item): string
    {
        if ($this->backpack) {
            return $this->backpack->addItem($item);  
        }
        return "Can't equip item since there is no backpack equipped";
    }

    /**
     * Add a weapon object to the human
     * @param Weapon $weapon - Weapon to be equipped
     * @return void
     */
    public function addWeapon(Weapon $weapon): void
    {
        $this->weapon = $weapon;
    }

    /**
     * Get the weapon objects name
     *
     * @return string the name of the weapon
     */
    public function getWeaponName(): string
    {
        return ucfirst($this->weapon?->getName() ?? "");
    }

    /**
     * Eat Food
     * Increase health by Food healing value
     * @return null|int
     */
    public function eatFood(Food $foodItem): ?int
    {
        if ($this->backpack) {
            $this->increaseHealth($foodItem->getHealingValue());
            $backPack = $this->backpack;
            $backPack->dropItem($foodItem);
        }
        return $this->getHealth();
    }

    /**
     * @return null|array<Item>
     */
    public function getItemsInBag(): ?array
    {
        return $this->backpack?->getItems();
    }

    /**
     * Use a weapon, causing dmg equal to baseattackpower + weapon dmg
     * @return int total dmg caused by attack
     */
    public function attackWithWeapon(): int
    {
        return $this->getAttackPower() + ($this->weapon?->getWeaponDmg() ?? 0);
    }

    /**
     * Get an item from your backpack
     * @return Item
     */
    public function getItemByName(string $name): Item
    {
        $items = $this->getItemsInBag();
        if ($items) {
            foreach($items as $item) {
                if ($item->getName() === $name) {
                    return $item;
                }
            }
        }
        throw new Exception("There is no item with name: $name");
    }
}
