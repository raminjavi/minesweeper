<?php

declare(strict_types=1);

namespace Game\classes;

class Position
{
    private array $position;

    public function __construct(int $x, int $y)
    {
        $this->position = ['x' => $x, 'y' => $y];
    }

    public function get(): array
    {
        return $this->position;
    }
    
}
