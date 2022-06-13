<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Game;
use Game\classes\Player;
use Game\classes\Position;

$board = new Board(7, 8);
$player1 = new Player("Bot one");
$player2 = new Player("Bot two");
$game = new Game($board, [$player1, $player2], 15, 8);


// Define witch Player must start the game
$player = "player1";

$boardDimensions = $board->getDimensions();


// $position = new Position(rand(0, $boardDimensions->x), rand(0, $boardDimensions->y));
// $p = $player1->play($game, $position);

// var_dump($p);
// exit;

$loopLimit = 1000;
while (!$game->isGameOver() && $loopLimit > 0) {

    try {
        // Generate a random position
        $position = new Position(rand(0, $boardDimensions->x), rand(0, $boardDimensions->y));

        // Play with selected Player
        $result = $$player->play($game, $position);
    } catch (\Exception $e) {
        continue;
    } finally {
        $loopLimit--;
    }

    // Switch Player's turn if the Player found a mine
    if (is_numeric($result)) {
        $player = $player == "player1" ? "player2" : "player1";
    }
}


var_dump($game->getResult());
