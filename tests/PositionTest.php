<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use Game\classes\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{

    public function testGetPosition()
    {
        $board = new Board(7, 8);
        $boardDimensions = $board->getDimensions();
        $position = new Position(rand(0, $boardDimensions->x), rand(0, $boardDimensions->y));
        $this->assertIsObject($position->get());
    }
}
