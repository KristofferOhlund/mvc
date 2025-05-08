<?php

namespace App\Game;

use App\Card\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the Player class
 */

class CardGraphicTestTest extends TestCase
{
    /**
     * Create object and verify that objects has expected properties
     */
    public function testCreateCardGraphic()
    {
        $card = new CardGraphic("hjärter", "red", "kung");

        $this->assertInstanceOf("App\Card\CardGraphic", $card);

        $this->assertIsString($card->getSymbol());

        // Make sure keys are in presentation
        $this->assertArrayHasKey("card", $card->getCardGraphicPresentation());
        $this->assertArrayHasKey("string", $card->getCardGraphicPresentation());
        $this->assertArrayHasKey("points", $card->getCardGraphicPresentation());
        $this->assertArrayHasKey("symbol", $card->getCardGraphicPresentation());

        // Make sure values are in presentation
        $this->assertContains("hjärter", $card->getCardGraphicPresentation());
        $this->assertContains("kung", $card->getCardGraphicPresentation());
        $this->assertContains(13, $card->getCardGraphicPresentation());
        $this->assertContains("🂾", $card->getCardGraphicPresentation());
    }
}