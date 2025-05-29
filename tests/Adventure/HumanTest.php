<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TestHuman extends TestCase
{   
    /**
     * Create instance of Human
     */
    public function testHumanInstance() {
        $human = new Human("Player");
        $this->assertInstanceOf(Human::class, $human);
    }

    /**
     * Test equip backpack
     */
    public function testHumanEquipBackPack() {
        $backpack = new BackPack();
        $human = new Human("Player");
        $this->assertSame($backpack, $human->equipBackPack($backpack));
    }

    /**
     * Test addItemToBackPack
     */
    public function testAddItemToBackPack()
    {
        $item = new Item("skull", "skull.png");
        $backpack = new BackPack();
        $human = new Human("DragonSlayer");
        $human->equipBackPack($backpack);

        $this->assertTrue($human->addItemToBackPack($item));
    }

    /**
     * Test addItemToBackPack
     */
    public function testAddItemToBackPackFalse()
    {
        $item = new Item("skull", "skull.png");
        $human = new Human("DragonSlayer");

        $this->assertFalse($human->addItemToBackPack($item));
    }

    /**
     * Get items in bag
     */
    public function testGetitemsInBag() {
        $backpack = new BackPack();
        $food = new Food("apple", 50, "apple.png");
        $weapon = new Weapon("sword", 100, "sword.png");
        $backpack->AddItem($food);
        $backpack->AddItem($weapon);

        $human = new Human("Player");
        $human->equipBackPack($backpack);
        $this->assertCount(2, $human->getItemsInBag());
    }

    /**
     * Get items in bag when empty
     */
    public function testGetitemsInBagEmpty() {
        $backpack = new BackPack();

        $human = new Human("Player");
        $human->equipBackPack($backpack);
        $this->assertCount(0, $human->getItemsInBag());
    }

    /**
     * Test attack with weapon
     */
    public function testHumanAttackWithWeapon() {
        $weapon = new Weapon("sword", 100, "sword.png");
        $human = new Human("Player");
        $human->addWeapon($weapon);
        $this->assertEquals(($human->getAttackPower() + 100) ,$human->attackWithWeapon($weapon));
    }

    /**
     * Test eat food
     */
    public function testHumanEatFood() {
        $food = new Food("apple", 50, "apple.png");
        $human = new Human("Player");
        $backpack = new BackPack();
        $human->equipBackPack($backpack);
        $backpack->AddItem($food);
        $this->assertSame(150, $human->eatFood($food));

    }

    /**
     * Assert getWeaponName as string
     */
    public function testgetWeaponName()
    {
        $weapon = new Weapon("sword", 100, "sword.png");
        $human = new Human("Player");
        $human->addWeapon($weapon);
        $this->assertSame("Sword", $human->getWeaponName());
    }

    
}