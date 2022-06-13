<?php

declare(strict_types=1);

namespace Game\classes;

class Board
{
    private int $x;
    private int $y;
    private array $cells;


    /**
     * @param array<int> $dimensions [x, y]
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
     * Create the board
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
     * @throws LogicException if Board has not been setup
     */
    public function getCells(): array
    {
        if (!isset($this->cells))
            throw new \LogicException("Board has not been setup yet");

        return $this->cells;
    }


    /**
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
     * @param array $dimensions
     * @return void
     * @throws InvalidArgumentException if dimensions were not natural integers
     */
    private function setDimensions(int $x, int $y): void
    {
        // if (count($dimensions) != 2) {
        //     throw new \InvalidArgumentException("The parameter 'dimensions' only accept two values, X and Y");
        // }

        // $x = intval($dimensions[0]);
        // $y = intval($dimensions[1]);

        if ($x < 0 || $y < 0)
            throw new \InvalidArgumentException("setDimensions method only accepts natrual integers. input was: ({$x}, {$y})");

        // Decrease inputs by one because $x and $y start from zero
        $this->x = $x - 1;
        $this->y = $y - 1;
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
