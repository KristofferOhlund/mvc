<?php

namespace App\Adventure;

use App\Adventure\Varelse;

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