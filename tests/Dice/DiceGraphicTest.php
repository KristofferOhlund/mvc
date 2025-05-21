<?php

namespace App\Dice;

use App\Dice\DiceHand;
use App\Dice\Dice;
use PHPUnit\Framework\TestCase;

final class DiceGraphicTest extends TestCase
{
    /**
     * Verify Instance of DiceHand
     */
    public function testDiceGraphicConstructor()
    {
        $hand = new DiceGraphic();

        $this->assertInstanceOf(DiceGraphic::class, $hand);
    }


    /**
     * Create DiceGraphic
     * Verify string value
     */
    public function testGetAsString()
    {
        $dice = new DiceGraphic();
        $dice->roll(2);
        $value = $dice->getAsString();

        $this->assertSame("⚁", $value);
    }


}
