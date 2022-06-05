<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use Game\classes\Cell;
use Game\classes\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{

    public function testGetPosition()
    {
        $board = new Board([new Player("Bot One")]);
        $dimensions = $board->getDimensions();
        $position = new Position(rand(0, $dimensions['x']), rand(0, $dimensions['y']));
    }
}
