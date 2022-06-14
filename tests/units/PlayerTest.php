<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use Game\classes\Position;
use Game\classes\Game;
use Game\classes\Mine;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{

    public function testCreateObject(): void
    {
        $player = new Player("John Doe");
        $this->assertInstanceOf(Player::class, $player);
    }


    public function testAddScore(): void
    {
        $player = new Player("John Doe");
        $this->assertIsInt($player->addScore(1));
    }


    public function testGetScores(): void
    {
        $player = new Player("John Doe");
        $this->assertIsInt($player->getScores());
    }


    public function testGetFullName(): void
    {
        $player = new Player("John Doe");
        $this->assertIsString($player->getFullName());
    }


    public function testIsWinner(): void
    {
        $player = new Player("John Doe");
        $this->assertIsBool($player->isWinner());
    }


    public function testPlay(): void
    {
        $board = new Board(7, 8);
        $player = new Player("John Doe");
        $game = new Game($board, [$player], 15, 8);

        $playResult = $player->play($game, new Position(1, 1));

        $this->assertThat($playResult, $this->logicalOr(
            $this->isType('int'),
            $this->isInstanceOf(Mine::class)
        ));
    }
}
