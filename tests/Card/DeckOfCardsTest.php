<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test case for DeckOfCards module
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Create object and verify properties
     */
    public function testCreateDeck()
    {
        $deck = new DeckOfCards();

        $deck->generateGraphicDeck();
        $deck->shuffleGraphic();
        $this->assertContainsOnlyInstancesOf(CardGraphic::class, $deck->getGraphicCards());
        $this->assertEquals(52, $deck->countGraphicCards());
        // draw card with arg
        $this->assertContainsOnlyInstancesOf(CardGraphic::class, $deck->drawGraphic(3));
        // draw card no arg
        $this->assertInstanceOf(CardGraphic::class, $deck->drawGraphic());

        // count after cards has been drawn
        $this->assertEquals(48, $deck->countGraphicCards());
    }

    /**
     * Create object and verify presentation
     */
    public function testGetArrayOfCardsPresentation()
    {
        $deck = new DeckOfCards();
        $deck->generateGraphicDeck();
        $cards = $deck->getGraphicCards();
        $presentation = $deck->getArrayOfCardsPresentation($cards);

        $this->assertIsArray($presentation);
        $this->assertIsIterable($presentation);
        $this->assertCount(52, $presentation);
    }
}
