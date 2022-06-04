<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{

    public function testCompareImplantedMinesWithTotalMines(): void
    {
        $board = new Board([new Player("Bot one"), new Player("Bot two")]);

        $totalMines = 0;
        foreach ($board->getBoard() as $cells) {
            foreach ($cells as $cell) {
                if ($cell->getMine()) {
                    $totalMines++;
                }
            }
        }

        $this->assertEquals($totalMines, $board->getTotalMines());
    }
}
