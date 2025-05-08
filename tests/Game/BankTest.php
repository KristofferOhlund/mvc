<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Bank
 */
class BankTest extends TestCase
{
    /**
     * Construct object without arguments
     */
    public function testCreateObjectNoArgs()
    {
        $player = new Bank();
        $name = $player->getName();
        $this->assertEquals("Bank", $name);

        $hand = $player->getCardHandClass();
        $this->assertSame("App\Card\CardHand", $hand);

        $cards = $player->showHand();
        $this->assertEmpty($cards);

        $stop = $player->getStop();
        $this->assertEquals(false, $stop);
    }

}
