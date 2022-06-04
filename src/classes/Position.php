<?php

declare(strict_types=1);

namespace Game\classes;

class Position
{
    private array $position;

    public function __construct(Board $board, int $x, int $y)
    {
        $this->position = $this->set($board, $x, $y);
    }

    public function get(): array
    {
        return $this->position;
    }

    public function set(Board $board, int $x, int $y): array
    {
        $dimensions = $board->getDimensions();
        if ($x > $dimensions['x'] || $y > $dimensions['y'])
            throw new \Exception("Position must be in range of {$dimensions['x']}x{$dimensions['y']}");

        return $this->position = ['x' => $x, 'y' => $y];
    }
    
}
