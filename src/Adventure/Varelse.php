<?php

namespace App\Adventure;

/**
 * Module representating a Dragon in the Adventure Game
 */
class Varelse
{

    /**
     * @var string|null $name
     */
    private string $name;

    /**
     * @var int|null $health
     */
    private int $health;

    /**
     * @var int|null $attackPower
     */
    private int $attackPower;


    public function __construct(string $name, int $health=100, int $attackPower=10)
    {   
        $this->name = $name; 
        $this->health = $health;
        $this->attackPower = $attackPower; 
    }

    /**
     * Attack, cause dmg equal to attackPower
     * @return int|null
     */
    public function attack(): ?int 
    {
        return $this->attackPower;
    }

    /**
     * Get attackPower
     */
    public function getAttackPower():int {
        return $this->attackPower;
    }


    /**
     * Public function to get current health
     * 
     * @return int|null
     */
    public function getHealth(): ?int {
        return $this->health;
    }


    /**
     * Reduce current health by dmg amount
     */
    public function reduceHealth(int $amount){
        $this->health -= $amount;
    }

    /**
     * Add health by healing value
     */
    public function increaseHealth(int $amount) {
        $this->health += $amount;
    }


    /**
     * Check if Varelse is dead
     * 
     * @return bool
     */
    public function isDead(): bool {
        if ($this->getHealth() <= 0) {
            return true;
        }
        return false;
    }

    /**
     * Return the name of the Varelse
     * 
     * @return string|null
     */
    public function getName(): ?string {
        return $this->name;
    }
}

