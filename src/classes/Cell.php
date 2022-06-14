<?php

declare(strict_types=1);

namespace Game\classes;

class Cell
{
    private Player $player;
    private Position $position;
    private ?Mine $mine = null;
    private int $totalMinesAround = 0;
    private bool $isMarked = false;
    private const CLOCKWISE_PATTERN = [
        ['y', '-'],
        ['x', '+'],
        ['y', '+'],
        ['y', '+'],
        ['x', '-'],
        ['x', '-'],
        ['y', '-'],
        ['y', '-'],
    ];



    /**
     * Create a new Cell instance.
     * 
     * @param Position $position
     * @return void
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
    }


    /**
     * Mark the cell as played and save the Player in it.
     * 
     * @param Player $player
     * @return Cell
     */
    public function mark(Player $player): Cell
    {
        $this->isMarked = true;
        $this->player = $player;
        return $this;
    }


    /**
     * @return bool
     */
    public function isMarked(): bool
    {
        return $this->isMarked;
    }


    /**
     * @return Player|null
     */
    public function getPlayer(): ?Player
    {
        return $this->player ?? null;
    }


    /**
     * @return Mine|null
     */
    public function getMine(): ?Mine
    {
        return $this->mine ?? null;
    }


    /**
     * Calculate existing Mines around the cell and return the sum.
     * 
     * @param Board $board
     * @return int $totalMinesAround
     */
    public function getMinesAround(Board $board): int
    {
        $scannerPosition = $this->position->get();

        // Scan around the cell (clockwise)
        foreach (self::CLOCKWISE_PATTERN as $item) {
            $axis = $item[0];
            $operator = $item[1];

            if ($operator == '+') {
                if ($axis == 'y') {
                    $scannerPosition->y++;
                } else {
                    $scannerPosition->x++;
                }
            } elseif ($operator == '-') {
                if ($axis == 'y') {
                    $scannerPosition->y--;
                } else {
                    $scannerPosition->x--;
                }
            }

            try {
                $position = new Position($scannerPosition->x, $scannerPosition->y);
                $adjacentCell = $board->getCell($position);

                if ($adjacentCell->getMine()) {
                    $this->totalMinesAround++;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $this->totalMinesAround;
    }


    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }


    /**
     * Plant Mine in the Cell
     * 
     * @return Mine
     */
    public function setMine(Mine $mine): Mine
    {
        return $this->mine = $mine;
    }
}
