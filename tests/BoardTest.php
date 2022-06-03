<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{

    public function testPlay(): void
    {
        $player1 = new Player("Bot one");
        $player2 = new Player("Bot two");
        $board = new Board([$player1, $player2]);

        // Generate 2 random positions for players
        $dimensions = $board->getDimensions();
        $randomPosition1 = [rand(0, $dimensions['x']), rand(0, $dimensions['y'])];
        while ($randomPosition1 != $position = [rand(0, $dimensions['x']), rand(0, $dimensions['y'])]) {
            $randomPosition2 = $position;
            break;
        }

        // Player1's turn
        $cell = $board->play($player1, $randomPosition1);
        $this->assertInstanceOf("Game\classes\Cell", $cell);

        // Player2's turn
        $cell = $board->play($player2, $randomPosition2);
        $this->assertInstanceOf("Game\classes\Cell", $cell);
    }
}
