<?php

declare(strict_types=1);
require_once __DIR__ . '/../../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Game;
use Game\classes\Player;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    public function testCreateObject(): void
    {
        $game = self::createGameObject();
        $this->assertInstanceOf(Game::class, $game);
    }


    public function testAddScoreToPlayer(): void
    {
        $player = new Player("John Doe");
        $game = new Game(
            new Board(rand(8, 15), rand(8, 15)),
            [$player],
            15,
            8
        );

        $this->assertInstanceOf(Player::class, $game->addScoreToPlayer($player));
    }


    public function testIsGameOver(): void
    {
        $game = self::createGameObject();
        $this->assertIsBool($game->isGameOver());
    }


    public function testGetwinner(): void
    {
        $game = self::createGameObject();
        $this->assertThat($game->getwinner(), $this->logicalOr(
            $this->isNull(),
            $this->isInstanceOf(Player::class)
        ));
    }


    public function testGetTotalMines(): void
    {
        $game = self::createGameObject();
        $this->assertIsInt($game->getTotalMines());
    }


    public function testGetBoard(): void
    {
        $game = self::createGameObject();
        $this->assertInstanceOf(Board::class, $game->getBoard());
    }


    public function testGetPlayedCellsHistory(): void
    {
        $game = self::createGameObject();
        $this->assertIsArray($game->getPlayedCellsHistory());
    }


    public function testComparePlantedMinesWithTotalMines(): void
    {
        $game = self::createGameObject();
        $gameBoard = $game->getBoard();

        $totalMines = 0;
        foreach ($gameBoard->getCells() as $cells) {
            foreach ($cells as $cell) {
                if ($cell->getMine()) {
                    $totalMines++;
                }
            }
        }

        $this->assertEquals($totalMines, $game->getTotalMines());
    }


    private static function createGameObject(): Game
    {
        return new Game(
            new Board(rand(8, 15), rand(8, 15)),
            [new Player("John Doe")],
            15,
            8
        );
    }
}
