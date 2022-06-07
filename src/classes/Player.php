<?php

declare(strict_types=1);

namespace Game\classes;

class Player
{
    public $fullName;
    private $totalScores = 0;

    public function __construct(string $fullName)
    {
        $this->fullName = $fullName;
    }

    public function play(Board $board, Position $position): Cell
    {
        $cell = $board->getCell($position);

        if ($cell->isMarked())
            throw new \Exception("The cell already marked by another player");

        // Scan mines around the cell
        $cell->calculateMinesAround($board);

        return $cell->mark($this);
    }

    public function addScore(int $scores): int
    {
        return $this->totalScores = $this->totalScores + $scores;
    }

    public function getTotalScores(): int
    {
        return $this->totalScores;
    }
}
