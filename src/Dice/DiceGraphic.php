<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    /**
     * Array with strings
     * each string item represents a dice
     * @var array<string>
     */
    private array $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get value as string
     * @return string
     */
    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
