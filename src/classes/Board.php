<?php

declare(strict_types=1);

namespace Game\classes;

class Board
{
    private int $x;
    private int $y;
    private array $cells;


    /**
     * Create a new Board instance.
     * 
     * @param int $x
     * @param int $y
     * @return void
     */
    public function __construct(int $x, int $y)
    {
        try {
            $this->setDimensions($x, $y);
            $this->createCells();
        } catch (\InvalidArgumentException $e) {
            die("Cannot make Board object: " . $e->getMessage());
        }
    }


    /**
     * Create cells of the board
     * 
     * @return void
     * @throws LogicException if the board dimensions have not been initialized
     */
    private function createCells(): void
    {
        if (!isset($this->x) || !isset($this->y))
            throw new \LogicException("Board dimensions have not been initialized");

        $rows = [];
        for ($y = 0; $y <= $this->y; $y++) {

            $column = [];
            for ($x = 0; $x <= $this->x; $x++) {
                $position = new Position($x, $y);
                $cell = new Cell($position);
                $column[] = $cell;
            }

            $rows[] = $column;
        }

        $this->cells = $rows;
    }


    /**
     * @return array
     * @throws LogicException if cells has not been created
     */
    public function getCells(): array
    {
        if (!isset($this->cells))
            throw new \LogicException("Cells has not been created yet");

        return $this->cells;
    }


    /**
     * Get Board dimensions (x,y)
     * 
     * @return object
     */
    public function getDimensions(): object
    {
        return (object) [
            'x' => $this->x,
            'y' => $this->y
        ];
    }


    /**
     * Get specific cell on the board
     * 
     * @param Position $position
     * @return Cell
     * @throws OutOfRangeException if Position was not in the board range
     */
    public function getCell(Position $position): Cell
    {
        $pos = $position->get();
        $dimensions = $this->getDimensions();

        if ($pos->x > $dimensions->x || $pos->y > $dimensions->y)
            throw new \OutOfRangeException("Position must be in the range of ({$dimensions->x}, {$dimensions->y})");

        return $this->cells[$pos->y][$pos->x];
    }



    /**
     * @param int $x
     * @param int $y
     * @return void
     * @throws InvalidArgumentException
     */
    private function setDimensions(int $x, int $y): void
    {
        if ($x < 0 || $y < 0)
            throw new \InvalidArgumentException("setDimensions method only accepts natrual integers. input was: ({$x}, {$y})");

        // Decrease inputs by one because $x and $y start from zero
        $this->x = intval($x - 1);
        $this->y = intval($y - 1);
    }


    // public function getMarkedCells(): array
    // {
    //     $markedCells = [];
    //     foreach ($this->getBoard() as $cells) {
    //         foreach ($cells as $cell) {
    //             if ($cell->isMarked()) {
    //                 $markedCells[] = $cell;
    //             }
    //         }
    //     }
    //     return $markedCells;
    // }
}
