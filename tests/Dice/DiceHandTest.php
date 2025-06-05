<?php

namespace App\Dice;

use App\Dice\DiceHand;
use App\Dice\Dice;
use PHPUnit\Framework\TestCase;

final class DiceHandTest extends TestCase
{
    /**
     * Verify Instance of DiceHand
     */
    public function testDiceHandConstructor()
    {
        $hand = new DiceHand();

        $this->assertInstanceOf(DiceHand::class, $hand);
    }


    /**
     * Create New DiceHand
     * Create Dice Instance
     * Add Dice to Hand
     * Verify values in hand
     */
    public function testDiceRoll()
    {
        $hand = new DiceHand();
        /** @var Dice&\PHPunit\Framework\MockObject\MockObject $dice */
        $dice = $this->createMock(Dice::class);
        $dice->method("roll")->willReturn(5);

        $hand->add($dice);
        $hand->roll();
        $this->assertSame(1, $hand->getNumberDices());
    }

    /**
     * Create New DiceHand
     * Create Dice Instance
     * Add Dice to Hand
     * Verify values in hand
     */
    public function testgetstring()
    {
        $hand = new DiceHand();
        /** @var Dice&\PHPunit\Framework\MockObject\MockObject $dice */
        $dice = $this->createMock(Dice::class);
        $dice->method("roll")->willReturn(5);

        $hand->add($dice);
        $hand->roll();
        $this->assertIsArray($hand->getString());
    }

    /**
     * Create New DiceHand
     * Create Dice Instance
     * Add Dice to Hand
     * Verify values in hand
     */
    public function testDiceHandValues()
    {
        $hand = new DiceHand();
        $dice = new dice();
        $dice->roll();
        $value = $dice->getValue();
        $hand->add($dice);
        $valuesInHand = $hand->getValues();

        $this->assertIsArray($valuesInHand);
        $this->assertIsInt($valuesInHand[0]);
        $this->assertSame($valuesInHand[0], $value);
    }


}
