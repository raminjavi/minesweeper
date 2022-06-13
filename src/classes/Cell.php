<?php

declare(strict_types=1);

namespace Game\classes;

class Cell
{
    private Mine $mine;
    private Player $player;
    private Position $position;
    private int $totalMinesAround = 0;
    private bool $isMarked = false;
    public const CLOCKWISE_PATTERN = [
        ['y', '-'],
        ['x', '+'],
        ['y', '+'],
        ['y', '+'],
        ['x', '-'],
        ['x', '-'],
        ['y', '-'],
        ['y', '-'],
    ];


    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    public function mark(Player $player): Cell
    {
        $this->isMarked = true;
        $this->player = $player;
        return $this;
    }

    public function isMarked(): bool
    {
        return $this->isMarked;
    }

    public function getPlayer(): ?Player
    {
        return $this->player ?? null;
    }

    public function getMine(): ?Mine
    {
        return $this->mine ?? null;
    }

    public function calculateMinesAround(Board $board): void
    {
        $cellPosition = $this->getPosition();
        $pointerPosition = $cellPosition->get();

        // Scan around the cell (clockwise)
        foreach (self::CLOCKWISE_PATTERN as $item) {
            $axis = $item[0];
            $operator = $item[1];

            if ($operator == '+') {
                if ($axis == 'y') {
                    $pointerPosition['y']++;
                } else {
                    $pointerPosition['x']++;
                }
            } else {
                if ($axis == 'y') {
                    $pointerPosition['y']--;
                } else {
                    $pointerPosition['x']--;
                }
            }

            try {
                $adjacentCellPosition = new Position($pointerPosition['x'], $pointerPosition['y']);
                if ($adjacentCell = $board->getCell($adjacentCellPosition)) {
                    if ($adjacentCell->getMine()) {
                        $this->totalMinesAround++;
                    }
                }
            } catch (\Exception $e) {
            }
        }
    }

    public function getTotalMinesAround(): int
    {
        return $this->totalMinesAround;
    }


    public function getPosition(): Position
    {
        return $this->position;
    }


    public function setMine(Mine $mine): Mine
    {
        return $this->mine = $mine;
    }
}
