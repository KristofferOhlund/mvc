<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Card;
use ValueError;

/**
 * Test cases for the Card class
 */
class CardTest extends TestCase
{
    /**
     * Create a cardObject
     */
    public function testCreateCardValidArgs()
    {
        $card = new Card("hjärter", "red", "dam");

        $this->assertInstanceOf("App\Card\Card", $card);
        $this->assertEquals("dam", $card->getCardStringValue());
        $this->assertEquals(12, $card->getCardValue());
        $this->assertEquals("red", $card->getCardColor());
        $this->assertEquals("hjärter", $card->getCardFamily());
    }

    public function testCreateCardInvalidArgs()
    {
        $this->expectException(CardException::class);
        $card = new Card("hjärtor", "red", "dam");
    }
}
