<?php

declare(strict_types=1);

namespace Game\classes;

class Player
{
    private string $fullName;
    private int $totalScores = 0;
    private bool $isWinner = false;


    /**
     * Create a new Player instance.
     * 
     * @param string $fullName
     * @return void
     */
    public function __construct(string $fullName)
    {
        $this->fullName = $fullName;
    }


    /**
     * Mark the cell as played,
     * Add a score to the player if the cell has a Mine 
     * otherwise return totalMines around the cell.
     * 
     * @param Game $game
     * @param Position $position
     * @return int|Mine
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

        // Add played cell to the game history
        $game->addPlayedCellToHistory($cell);

        // If Player found a mine, then give him a score
        if ($mine = $cell->getMine()) {
            $mine->find($this);
            $game->addScoreToPlayer($this);
            return $mine;
        }

        return $cell->getMinesAround($board);
    }


    /** 
     * @param int $score
     * @return int $totalScores
     */
    public function addScore(int $scores): int
    {
        return $this->totalScores = $this->totalScores + $scores;
    }


    /** 
     * @return int $totalScores
     */
    public function getScores(): int
    {
        return $this->totalScores;
    }


    /** 
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;;
    }


    /** 
     * @return bool
     */
    public function isWinner(): bool
    {
        return $this->isWinner;
    }


    /** 
     * Set isWinner property to true
     * 
     * @return void
     */
    public function win(): void
    {
        $this->isWinner = true;
    }
}
