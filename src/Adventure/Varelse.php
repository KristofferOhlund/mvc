<?php

namespace App\Adventure;

/**
 * Module representating a Dragon in the Adventure Game
 */
class Varelse
{
    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var int $health
     */
    private int $health;

    /**
     * @var int $attackPower
     */
    private int $attackPower;


    public function __construct(string $name, int $health = 100, int $attackPower = 10)
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
    public function getAttackPower(): int
    {
        return $this->attackPower;
    }


    /**
     * Public function to get current health
     *
     * @return int|null
     */
    public function getHealth(): ?int
    {
        return $this->health;
    }


    /**
     * Reduce current health by dmg amount
     *
     * @return int
     */
    public function reduceHealth(int $amount): int
    {
        return $this->health -= $amount;
    }

    /**
     * Add health by healing value
     *
     * @return int
     */
    public function increaseHealth(int $amount): int
    {
        return $this->health += $amount;
    }


    /**
     * Check if Varelse is dead
     *
     * @return bool
     */
    public function isDead(): bool
    {
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
    public function getName(): ?string
    {
        return $this->name;
    }
}
