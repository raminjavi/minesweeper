<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use Game\classes\Position;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testPlay(): void
    {
        $player1 = new Player("Bot one");
        $player2 = new Player("Bot two");
        $board = new Board([$player1, $player2]);

        // Generate 2 random positions for players
        $dimensions = $board->getDimensions();
        $randomPosition1 = new Position(rand(0, $dimensions['x']), rand(0, $dimensions['y']));
        while (!isset($randomPosition2)) {
            $pos = new Position(rand(0, $dimensions['x']), rand(0, $dimensions['y']));
            if ($randomPosition1->get() != $pos->get()) {
                $randomPosition2 = $pos;
                break;
            }
        }

        // Player1's turn
        $cell = $player1->play($board, $randomPosition1);
        $this->assertTrue($cell->isMarked());

        // Player2's turn
        $cell = $player2->play($board, $randomPosition2);
        $this->assertTrue($cell->isMarked());
    }
}
