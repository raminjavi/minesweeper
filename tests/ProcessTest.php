<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;
use Game\classes\Position;
use Game\classes\Game;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{

    public function testGameProcess(): void
    {
        $board = new Board(7, 8);
        $player1 = new Player("Bot one");
        $player2 = new Player("Bot two");
        $game = new Game($board, [$player1, $player2], 15, 8);

        // Get Board dimensions
        $boardDimensions = $board->getDimensions();

        // Define witch Player must start the game
        $player = "player1";

        // It's always a good idea to define a limitation for while loops
        $loopLimit = 1000;

        while (!$game->isGameOver() && $loopLimit > 0) {

            try {
                // Generate a random position
                $position = new Position(rand(0, $boardDimensions->x), rand(0, $boardDimensions->y));

                // Play with selected Player
                $playResult = $$player->play($game, $position);
            } catch (\Exception $e) {
                continue;
            } finally {
                $loopLimit--;
            }

            // Switch Player's turn if the Player could not find a mine
            if (is_numeric($playResult)) {
                $player = $player == "player1" ? "player2" : "player1";
            }
        }

        $this->assertIsArray($game->getResult());
    }
}
