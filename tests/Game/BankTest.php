<?php

namespace App\Game;

use App\Card\DeckOfCards;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
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

        $stop = $player->hasStop();
        $this->assertEquals(false, $stop);
    }

    /**
     * Test bankDrawCard method
     */
    public function testBankDrawCard()
    {
        $bank = new Bank();

        /** @var DeckOfCards&\PHPunit\Framework\MockObject\MockObject $deck*/
        $deck = $this->createMock(DeckOfCards::class);

        /** @var CardGraphic&\PHPunit\Framework\MockObject\MockObject $card*/
        $card = $this->createMock(CardGraphic::class);
        $card->method("getCardValue")->willReturn(22);

        $deck->method("drawGraphic")->willReturn($card);
        $bank->bankDrawCard($deck);
        $this->assertTrue($bank->hasStop());
        $this->assertEquals(22, $bank->getPoints());
    }

}
