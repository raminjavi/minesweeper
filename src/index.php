<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Player;

try {

    $player1 = new Player("Ramin Javi");
    $player2 = new Player("Sara Sarbandi");
    $board = new Board([$player1, $player2]);

    var_dump($board->getBoard());
} catch (\Exception $e) {
    die('Message: ' . $e->getMessage());
}