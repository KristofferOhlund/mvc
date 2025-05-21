<?php

/**
 * Modelclass - the M in MVC
 * Also called applicationclass, as it is one of many classes
 * that builds the application.
 */

namespace App\Dice;

class Dice
{
    protected ?int $value;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->value = null;
    }

    /**
     * Roll a random dice value
     * if roll value, set this->value to value
     * @return int
     */
    public function roll(?int $value = null): int
    {
        $this->value = $value ?? random_int(1, 6);
        return $this->value;
    }

    /**
     * Get value as int or null
     * @return int|null
     */
    public function getValue(): int | null
    {
        return $this->value;
    }

    /**
     * return value as string
     * @return string
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
