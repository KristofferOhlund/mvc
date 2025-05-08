<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;
use App\Card\CardGraphic;
use App\Card\CardHand;
use phpDocumentor\Reflection\Types\Void_;
use SebastianBergmann\Type\VoidType;

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