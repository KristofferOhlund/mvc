<?php

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the Player class
 */

class PlayerTest extends TestCase
{
    /**
     * Create object without any arguments
     * Test all constructor-initiated values
     */
    public function testCreatePlayerNoArgs()
    {
        $player = new Player();
        $name = $player->getName();
        $this->assertEquals("player", $name);

        $hand = $player->getCardHandClass();
        $this->assertSame("App\Card\CardHand", $hand);

        $cards = $player->showHand();
        $this->assertEmpty($cards);

        $stop = $player->getStop();
        $this->assertEquals(false, $stop);
    }


    /**
     * Create Player object and set stop to True
     * Verify that value has been updated
     */
    public function testPlayerSetStop()
    {
        $player = new Player();
        $player->stop();
        $isStopped = $player->getStop();

        $this->assertTrue($isStopped);
    }

    /**
     * Verify that player->getPoints returns an integer
     *
     */
    public function testPlayerPointsIsInt()
    {
        $points = new Player()->getPoints();
        $this->assertIsInt($points);
    }

    /**
     * Draw a card from the deck of cards and add to the players hand
     */
    public function testPlayerDrawAddCard()
    {
        $player = new Player();

        /** @var DeckOfCards&\PHPUnit\Framework\MockObject\MockObject $deckMock */
        $deckMock = $this->createMock(DeckOfCards::class);

        /** @var CardGraphic&\PHPUnit\Framework\MockObject\MockObject $cardMock */
        $cardMock = $this->createMock(CardGraphic::class);

        $deckMock->method("drawGraphic")->willReturn($cardMock);

        $expected = $cardMock;

        $this->assertEquals($expected, $player->drawCard($deckMock));

        $this->assertNull($player->addCard($expected));
    }

    /**
     * Make sure showSymbolsInHand returns an array of strings
     */
    public function testShowSymbolsInHand()
    {
        $player = new Player();
        /** @var CardGraphic&\PHPUnit\Framework\MockObject\MockObject $cardMock */
        $cardMock = $this->createMock(CardGraphic::class);

        $player->addCard($cardMock);

        $this->assertIsArray($player->showSymbolsInHand());
    }

    /**
     * Make sure getPlayerRepresentation returns an array
     */
    public function testPlayerRepresentation()
    {
        $player = new Player();

        /** @var CardGraphic&\PHPUnit\Framework\MockObject\MockObject $cardMock */
        $cardMock = $this->createMock(CardGraphic::class);
        $cardMock->method("getCardGraphicPresentation")->willReturn([]);

        $player->addCard($cardMock);
        $this->assertIsArray($player->getPlayerRepresentation());
    }
}
