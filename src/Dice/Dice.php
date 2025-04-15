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

    public function __construct()
    {
        $this->value = null;
    }

    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}