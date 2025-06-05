<?php

namespace App\Adventure;

use App\Adventure\Varelse;

/**
 * Class representing a Dragon, extending the Varelse class.
 * Dragon acts as the main villain in the Adventure Game.
 */
class Dragon extends Varelse
{
    private int $fireDmg = 10;

    public function __construct()
    {
        parent::__construct("DeathWing", 150, 50);
    }

    /**
     * SprayFire, causing baseDmg + fireDmg
     */
    public function sprayFire(): int
    {
        return $this->attack() + $this->fireDmg;
    }
}
