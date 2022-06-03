<?php

declare(strict_types=1);

namespace Game\classes;

use Game\classes\Cell;

class Board
{
    private int $x;
    private int $y;
    private array $board;
    private array $players;
    private int $totalScores;
    private int $totalBonuses;

    public function __construct(array $players, int $totalScores = 8, int $totalBonuses = 15, array $dimensions = [6, 7])
    {
        $this->players = $players;
        $this->totalScores = $totalScores;
        $this->totalBonuses = $totalBonuses;
        $this->createBoard($dimensions);
    }


    public function createBoard(array $dimensions): void
    {
        /* 
            TODO: Validate Dimensions
                - Dimensions must not be less than 2*2
                - Dimensions must start from 1 not zero
        */
        $this->x = abs(intval($dimensions[0]));
        $this->y = abs(intval($dimensions[1]));

        // Create the board
        $row = [];
        for ($rowIndex = 0; $rowIndex <= $this->x; $rowIndex++) {

            $column = [];
            for ($columnIndex = 0; $columnIndex <= $this->y; $columnIndex++) {
                $column[] = new Cell;
            }

            $row[] = $column;
        }

        $this->board = $row;
    }

    public function getBoard(): array
    {
        return $this->board;
    }

    public function getDimensions(): array
    {
        return ['x' => $this->x, 'y' => $this->y];
    }

    public function getCell(array $position): Cell
    {
        $position = $this->validatePosition($position);
        $x = $position['x'];
        $y = $position['y'];

        $board = $this->getBoard();
        return $board[$x][$y];
    }

    public function getPlayers(): array
    {
        return $this->players;
    }


    public function play(Player $player, array $position): Cell
    {
        $position = $this->validatePosition($position);
        $x = $position['x'];
        $y = $position['y'];

        $cell = $this->getCell([$x, $y]);
        if ($cell->isMarked()) {
            throw new \Exception("The cell already marked by another player");
        }

        $cell->setPlayer($player);
        return $cell;
    }

    public function getMarkedCells(): array
    {
        $markedCells = [];
        foreach ($this->getBoard() as $boardRow) {
            foreach ($boardRow as $cell) {
                if ($cell->isMarked()) {
                    $markedCells[] = $cell;
                }
            }
        }
        return $markedCells;
    }


    public function validatePosition(array $position): array
    {
        $errorMessage = "Position array must have 2 absolute integers as X and Y";
        if (count($position) != 2)
            throw new \Exception($errorMessage);

        $x = $position[0];
        $y = $position[1];
        if (!is_numeric($x) || !is_numeric($y))
            throw new \Exception($errorMessage);

        $x = intval($x);
        $y = intval($y);
        if ($x < 0 || $y < 0)
            throw new \Exception($errorMessage);

        $x = abs($x);
        $y = abs($y);
        if ($x > $this->x || $y > $this->y)
            throw new \Exception("Position must be in range of {$this->x}x{$this->y}");

        return ['x' => $x, 'y' => $y];
    }
}
