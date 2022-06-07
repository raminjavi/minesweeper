<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use Game\classes\Position;
use Game\classes\GameState;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testPlay(): void
    {
        $board = new Board();
        $player1 = new Player("Bot one");
        $player2 = new Player("Bot two");

        $boardDimensions = $board->getDimensions();
        $gameState = new GameState($board, [$player1, $player2]);

        // Define witch Player must start the game
        $player = "player1";

        while (!$gameState->isGameOver()) {

            $position = new Position(rand(0, $boardDimensions['x']), rand(0, $boardDimensions['y']));
            if (!$gameState->isPositionPlayable($position)) {
                continue;
            }

            // Play with selected Player
            $cell = $$player->play($board, $position);

            // If the Player found a mine, then give him a score
            if ($cell->getMine()) {
                $gameState->addScoreToPlayer($$player);
            } else {
                // Switch Player's turn
                $player = $player == "player1" ? "player2" : "player1";
            }
        }

        $this->assertInstanceOf("Game\classes\Player", $gameState->getWiner());
    }
}
