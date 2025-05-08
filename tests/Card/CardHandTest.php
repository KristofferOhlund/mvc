<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test case for CardHand
 */
class CardHandTest extends TestCase
{
    /**
     * Create TestHand object and verify property
     */
    public function testCreateHand()
    {
        $hand = new CardHand();
        $this->assertInstanceOf("App\Card\CardHand", $hand);

        $this->assertIsArray($hand->getCardsInHand());


        /** @var CardGraphic&\PHPunit\Framework\MockObject\MockObject $card */
        $card = $this->createMock(CardGraphic::class);
        $card->method("getCardValue")->willReturn(5);

        $hand->addCard($card);

        $this->assertEquals(5, $hand->getPointsOfHand());
    }
}
