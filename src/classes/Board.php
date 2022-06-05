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
        // TODO: what if we want to create a board with different dimensions?!
        $this->setDimensions(7, 8);
        $this->createBoard();

        $this->setPlayers($players);
        $this->setTotalScores(8);
        $this->plantMines(15);
    }

    private function createBoard(): void
    {
        if (!isset($this->x) || !isset($this->y)) {
            throw new \Exception("Board dimensions has not initialized");
        }

        $row = [];
        for ($y = 0; $y <= $this->y; $y++) {

            $column = [];
            for ($x = 0; $x <= $this->x; $x++) {
                $position = new Position($x, $y);
                $cell = new Cell($position);
                $column[] = $cell;
            }

            $row[] = $column;
        }

        $this->board = $row;
    }


    public function getBoard(): array
    {
        if (!isset($this->board)) {
            throw new \Exception("Board has not created");
        }

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
        $dimensions = $this->getDimensions();

        if ($pos['x'] > $dimensions['x'] || $pos['y'] > $dimensions['y'])
            throw new \Exception("Position must be in range of {$dimensions['x']}x{$dimensions['y']}");

        return $board[$pos['y']][$pos['x']];
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getMarkedCells(): array
    {
        $markedCells = [];
        foreach ($this->getBoard() as $cells) {
            foreach ($cells as $cell) {
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

    private function plantMines(int $totalMines): int
    {
        $this->totalMines = abs($totalMines);

        // Since X and Y start from zero, we must increase them by 1
        $x = $this->x + 1;
        $y = $this->y + 1;

        if ($this->totalMines > ($x * $y)) {
            throw new \Exception("Mines must be less than Board cells");
        }

        $plantedMines = 0;
        $board = $this->getBoard();
        while ($plantedMines < $this->totalMines) {
            if (rand(0, 100) % 2) {
                $randomY = rand(0, $this->y);
                $randomX = rand(0, $this->x);
                $cell = $board[$randomY][$randomX];
                if (!$cell->getMine()) {
                    $mine = new Mine;
                    $cell->setMine($mine);
                    $plantedMines++;
                }
            }
        }
        return $plantedMines;
    }

    private function setTotalScores(int $totalScores): int
    {
        return $this->totalScores = abs($totalScores - 1);
    }

    private function setDimensions(int $x, int $y): array
    {
        $this->x = abs($x - 1);
        $this->y = abs($y - 1);
        return [$this->x, $this->y];
    }

    private function setPlayers(array $players): array
    {
        $playersArray = [];
        foreach ($players as $player) {
            if (!$player instanceof Player) {
                throw new \Exception("Invalid Player type");
            }
            $playersArray[] = $player;
        }
        $this->players = $playersArray;
        return $this->players;
    }
}
