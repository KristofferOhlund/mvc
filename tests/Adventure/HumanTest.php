<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TestHuman extends TestCase
{
    /**
     * Create instance of Human
     */
    public function testHumanInstance()
    {
        $human = new Human("Player");
        $this->assertInstanceOf(Human::class, $human);
    }

    /**
     * Test equip backpack
     */
    public function testHumanEquipBackPack()
    {
        $backpack = new BackPack();
        $human = new Human("Player");
        $this->assertSame($backpack, $human->equipBackPack($backpack));
    }

    /**
     * Test addItemToBackPack
     */
    public function testaddItemToBackPack()
    {
        $item = new Item("skull", "skull.png");
        $backpack = new BackPack();
        $human = new Human("DragonSlayer");
        $human->equipBackPack($backpack);

        $this->assertSame("Skulladded to inventory", $human->addItemToBackPack($item));
    }

    /**
     * Test addItemToBackPack
     */
    public function testaddItemToBackPackFalse()
    {
        $item = new Item("skull", "skull.png");
        $human = new Human("DragonSlayer");

        $this->assertSame("Can't equip item since there is no backpack equipped", $human->addItemToBackPack($item));
    }

    /**
     * Test attack with weapon
     */
    public function testHumanAttackWithWeapon()
    {
        $weapon = new Weapon("sword", 100, "sword.png");
        $human = new Human("Player");
        $human->addWeapon($weapon);
        $this->assertEquals(($human->getAttackPower() + 100), $human->attackWithWeapon($weapon));
    }

    /**
     * Test eat food
     */
    public function testHumanEatFood()
    {
        $food = new Food("apple", 50, "apple.png");
        $human = new Human("Player");
        $backpack = new BackPack();
        $human->equipBackPack($backpack);
        $backpack->addItem($food);
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

    /**
     * Test get item by name
     */
    public function testgetItemByName()
    {
        $human = new Human("dragonslayer");
        $apple = new Food("Apple", 100, "apple.png");
        $backpack = new BackPack();
        $backpack->addItem($apple);
        $human->equipBackPack($backpack);

        $item = $human->getItemByName("Apple");
        $this->assertSame("Apple", $item->getName());
        $this->assertInstanceOf(Food::class, $item);
    }

    /**
     * Test get item by name Exception
     */
    public function testgetItemByNameException()
    {
        $human = new Human("dragonslayer");
        $backpack = new BackPack();
        $human->equipBackPack($backpack);
        $food = "mango";
        $this->expectExceptionMessage("There is no item with name: $food");
        $human->getItemByName($food);
    }


}
