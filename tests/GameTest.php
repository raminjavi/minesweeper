<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Game;
use Game\classes\Player;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    public function testComparePlantedMinesWithTotalMines(): void
    {
        $game = new Game(
            new Board(7, 8),
            [
                new Player("player 1"),
                new Player("player 2")
            ],
            15,
            8
        );

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
}
