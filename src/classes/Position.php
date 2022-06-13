<?php

declare(strict_types=1);

namespace Game\classes;

class Position
{
    private array $position;


    /**
     * Create a new Position instance.
     *
     * @param int $x
     * @param int $y
     * @return array $position ['x' => $x, 'y' => $y]
     * @throws InvalidArgumentException if $x or $y were not natural integers.
     */
    public function __construct(int $x, int $y)
    {
        if ($x < 0 || $y < 0)
            throw new \InvalidArgumentException("Position must contain natural integers. Input was: ({$x}, {$y})");

        $this->position = ['x' => $x, 'y' => $y];
    }

    public function get(): array
    {
        return $this->position;
    }
}
