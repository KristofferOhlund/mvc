<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;

class TestDragon extends TestCase
{   
    /**
     * Create instance of BackPack
     */
    public function testDragonInstance() {
        $dragon = new Dragon();
        $this->assertInstanceOf(Dragon::class, $dragon);
    }

    public function testDragonHealth() {
        $dragon = new Dragon();
        $this->assertEquals(150, $dragon->getHealth());
    }

    public function testDragonDmg() {
        $dragon = new Dragon();
        $this->assertEquals(60, $dragon->sprayFire());
    }

    public function testDragonIsDead() {
        $dragon = new Dragon();
        $dragon->reduceHealth(50);
        $this->assertFalse($dragon->isDead());
    }

    public function testDragonSetDead() {
        $dragon = new Dragon();
        $health = $dragon->getHealth();
        $dragon->reduceHealth($health);
        $this->assertTrue($dragon->isDead());
    }

    public function testDragonGetName() {
        $dragon = new Dragon();
        $name = $dragon->getName();
        $this->assertEquals("DeathWing", $name);
    }

    public function testDragonGetAttackPower() {
        $dragon = new Dragon();
        $power = $dragon->getAttackPower();
        $this->assertEquals(50, $power);
    }



}