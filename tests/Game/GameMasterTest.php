<?php

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Game\GameMaster;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the Player class
 */

class GameMasterTest extends TestCase
{
    /**
     * Create object with Player arguments
     */
    public function testCreateGameMaster()
    {
        /** @var Player&\PHPunit\Framework\MockObject\MockObject $player */
        $player = $this->createMock(Player::class);

        $gameMaster = new GameMaster($player);

        $this->assertInstanceOf("App\Game\GameMaster", $gameMaster);

        $this->assertEquals(1, $gameMaster->getQueueCount());
        $this->assertEquals(1, $gameMaster->getPlayerCount());
        $this->assertIsArray($gameMaster->getPlayers());
        $this->assertInstanceOf("App\Game\Bank", $gameMaster->getBank());
    }


    /**
     * Create object and test peek, dequeue and enqueue
     */
    public function testGameMasterQueue()
    {
        /** @var Player&\PHPunit\Framework\MockObject\MockObject $player */
        $player = $this->createMock(Player::class);

        $gameMaster = new GameMaster($player);

        $this->assertInstanceOf("App\Game\Player", $gameMaster->peek());
        $this->assertInstanceOf("App\Game\Player", $gameMaster->dequeue());
        $this->assertNull($gameMaster->enqueue($player));
    }


    public function testGameMasterWinner()
    {
        /** @var Player&\PHPunit\Framework\MockObject\MockObject $player*/
        $player = $this->createMock(Player::class);
        /** @var Player&\PHPunit\Framework\MockObject\MockObject $player1*/
        $player1 = $this->createMock(Player::class);

        $player->method("getPoints")->willReturn(22);
        $player1->method("getPoints")->willReturn(10);

        $gameMaster = new GameMaster($player);
        $gameMaster->addPlayer($player1);

        $this->assertIsBool($gameMaster->checkPlayersDone());
        $this->assertIsArray($gameMaster->declareWinner());

        $gameMaster->enqueue($player1);

        $this->assertInstanceOf(
            "App\Game\Player",
            $gameMaster->getClosestPlayerTest()
        );
    }
}
