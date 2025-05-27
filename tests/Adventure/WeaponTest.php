<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;

class TestWeapon extends TestCase
{   
    /**
     * Create instance of Food
     */
    public function testWeaponInstance()
    {
        $weapon = new Weapon("Sword", 100, "sword.png");
        $this->assertInstanceOf(Weapon::class, $weapon);
    }

    /**
     * Assert weapon dmg
     */
    public function testGetWeaponDmg() {
        $weapon = new Weapon("Sword", 100, "sword.png");
        $dmg = $weapon->getWeaponDmg();

        $this->assertSame(100, $dmg);
    }

    /**
     * Assert weapon icon
     */
    public function testWeaponIcon()
    {
        $weapon = new Weapon("Sword", 100, "sword.png");
        $icon = $weapon->getIcon();

        $this->assertSame("sword.png", $icon);
    }

    
}