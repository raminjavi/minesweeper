<?php

declare(strict_types=1);

namespace Game\classes;

class Player
{
    private int $scores = 0;
    private string $fullName;
    private bool $isWinner = false;


    public function __construct(string $fullName)
    {
        $this->fullName = $fullName;
    }


    /**
     * Calculate mines around the cell and mark the cell as played.
     * @param Game $game
     * @param Position $position
     * @return Cell
     * @throws LogicException if the cell was already marked as played
     */
    public function play(Game $game, Position $position): int|Mine
    {
        $board = $game->getBoard();

        try {
            $cell = $board->getCell($position);
        } catch (\OutOfRangeException $e) {
            die("Cannot get the cell: " . $e->getMessage());
        }

        if ($cell->isMarked())
            throw new \LogicException("Cell already marked by another player");


        // Mark the cell
        $cell->mark($this);

        // If Player found a mine, then give him a score
        if ($mine = $cell->getMine()) {
            $game->addScoreToPlayer($this);
            return $mine;
        }

        return $cell->getMinesAround($board);
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

    public function isWinner(): bool
    {
        return $this->isWinner;
    }

    public function win(): void
    {
        $this->isWinner = true;
    }
}
