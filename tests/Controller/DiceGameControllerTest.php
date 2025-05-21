<?php

/**
 * Test module for the DiceGameController class
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Dice\DiceGraphic;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;

class DiceGameControllerTest extends WebTestCase
{
    /**
     * Test route response for DiceGame
     */
    public function testPigStart(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig');

        $this->assertResponseIsSuccessful();
    }
}
