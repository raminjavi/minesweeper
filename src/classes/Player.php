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

    public function addToScores(int $scores): int
    {
        $this->totalScores = $this->totalScores + $scores;
        return $this->totalScores;
    }

    public function getTotalScores(): int
    {
        return $this->totalScores;
    }

    public function play(Board $board, Position $position): Cell
    {
        $cell = $board->getCell($position);

        if ($cell->isMarked()) {
            throw new \Exception("The cell already marked by another player");
        }

        $result = $cell->mark($this);
        if ($result instanceof Mine) {
            $this->addToScores(1);
            echo ("Mine Found\n\r");
        } else {
            echo "No mines\n\r";
        }

        return $cell;
    }
}
