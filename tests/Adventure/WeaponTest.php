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
        $weapon = new Weapon("Sword", 100);
        $this->assertInstanceOf(Weapon::class, $weapon);
    }

    public function testGetWeaponDmg() {
        $weapon = new Weapon("Sword", 100);
        $dmg = $weapon->getWeaponDmg();

        $this->assertSame(100, $dmg);
    }
    
}