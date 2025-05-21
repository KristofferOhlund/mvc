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

    public function testRollDice(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/game/pig/test/roll');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", "Roll a dice");
        $this->assertCount(1, $crawler->filter(".die"));
    }

    public function testRollManyFail(): void
    {   
        
        $client = static::createClient();
        $client->catchExceptions(false);
        $this->expectException(\Exception::class);
        $crawler = $client->request('GET', '/game/pig/test/roll/100', ["num_dices" => 100]);
    }

    public function testRollManySuccess(): void
    {   
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/roll/89', ["num_dices" => 89]);
        $this->assertSelectorTextContains("h1", "Roll many dices");
    }


    public function testDiceHandFail(): void
    {   
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/dicehand/100', ["num" => 100]);
        // $client->catchExceptions(false);
        // $this->expectException(Exception::class);
        $this->assertResponseStatusCodeSame(500);
    }

    public function testDiceHandSuccess(): void
    {   
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/dicehand/58', ["num" => 58]);
        $this->assertResponseStatusCodeSame(200);
    }

    public function testInit() {
        $client = static::createClient();
        $client->request('GET', '/game/pig/init');
        $this->assertSelectorTextContains("h1", "Pig game [START]");
    }

    public function testSave(): void
    {
        $client = static::createClient();
        $client->request('POST', '/game/pig/save');
        $client->followRedirects();
        $this->assertResponseRedirects();
    }
}
