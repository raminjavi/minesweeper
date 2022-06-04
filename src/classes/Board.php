<?php

declare(strict_types=1);

namespace Game\classes;

use Game\classes\Cell;
use Game\classes\Mine;

class Board
{
    private int $x;
    private int $y;
    private array $board;
    private array $players;
    private int $totalMines;
    private int $totalScores;

    public function __construct(array $players)
    {
        $this->players = $players;
        $this->setTotalScores(8);
        $this->setTotalMines(15);
        $this->setDimensions(7, 8);
        $this->createBoard();
    }

    private function createBoard(): void
    {
        if (!isset($this->x) || !isset($this->y)) {
            throw new \Exception("Initialize Board dimensions first");
        }

        if ($this->totalMines >= ($this->x * $this->y)) {
            throw new \Exception("TotalMines must be less than Board dimensions");
        }

        $row = [];
        $counter = 0;
        for ($rowIndex = 0; $rowIndex <= $this->x; $rowIndex++) {

            $column = [];
            for ($columnIndex = 0; $columnIndex <= $this->y; $columnIndex++) {

                $counter++;
                $cell = new Cell;

                if ($this->totalMines >= $counter) {
                    $mine = new Mine;
                    $cell->setMine($mine);
                }

                $column[] = $cell;
            }

            shuffle($column);
            $row[] = $column;
        }

        shuffle($row);
        $this->board = $row;
    }


    public function getBoard(): array
    {
        return $this->board;
    }

    public function getDimensions(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y
        ];
    }

    public function getCell(Position $position): Cell
    {
        $pos = $position->get();
        $board = $this->getBoard();
        return $board[$pos['x']][$pos['y']];
    }

    public function getPlayers(): array
    {
        return $this->players;
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

    public function getTotalMines(): int
    {
        return $this->totalMines;
    }


    /* Setters
    __________________________________________________________*/
    public function setTotalMines(int $totalMines): int
    {
        return $this->totalMines = abs($totalMines - 1);
    }

    public function setTotalScores(int $totalScores): int
    {
        return $this->totalScores = abs($totalScores - 1);
    }

    public function setDimensions(int $x, int $y): array
    {
        $this->x = abs($x - 1);
        $this->y = abs($y - 1);
        return [$this->x, $this->y];
    }
}
