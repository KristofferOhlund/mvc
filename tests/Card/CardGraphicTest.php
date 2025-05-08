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
        $presentation = $card->getCardGraphicPresentation();

        $this->assertArrayHasKey("card", $presentation);
        $this->assertArrayHasKey("string", $presentation);
        $this->assertArrayHasKey("points", $presentation);
        $this->assertArrayHasKey("symbol", $presentation);

        // Make sure values are in presentation
        $this->assertContains("hjärter", $presentation);
        $this->assertContains("kung", $presentation);
        $this->assertContains(13, $presentation);
        $this->assertContains("🂾", $presentation);
    }
}
