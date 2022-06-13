<?php

declare(strict_types=1);

namespace Game\classes;

class Player
{
    private $fullName;
    private $scores = 0;


    public function __construct(string $fullName)
    {
        $this->fullName = $fullName;
    }


    /**
     * Calculate mines around the cell and mark the cell as played.
     * @abstract
     * @param Board $board
     * @param Position $position
     * @return Cell
     * @throws LogicException if the cell was already played
     */
    public function play(Board $board, Position $position): Cell
    {
        $cell = $board->getCell($position);

        if ($cell->isMarked())
            throw new \LogicException("Cell already marked by another player");

        // Scan mines around the cell
        $cell->calculateMinesAround($board);

        return $cell->mark($this);
    }


    public function addScore(int $scores): int
    {
        return $this->scores = $this->scores + $scores;
    }


    public function getScores(): int
    {
        return $this->scores;
    }


    public function getFullName(): string
    {
        return $this->fullName;;
    }
}
