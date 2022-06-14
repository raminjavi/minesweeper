<?php

declare(strict_types=1);
require_once __DIR__ . '/../../vendor/autoload.php';

use Game\classes\Cell;
use Game\classes\Board;
use Game\classes\Position;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testCreateObject(): void
    {
        $board = new Board(7, 8);
        $this->assertInstanceOf(Board::class, $board);
    }


    public function testGetCell(): void
    {
        $board = new Board(7, 8);
        $boardDimensions = $board->getDimensions();
        $position = new Position(rand(0, $boardDimensions->x), rand(0, $boardDimensions->y));
        $this->assertInstanceOf(Cell::class, $board->getCell($position));
    }
}
