<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Game\classes\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{

    public function testCreateObject(): void
    {
        $position = new Position(1, 1);
        $this->assertInstanceOf(Position::class, $position);
    }

    public function testGetPosition()
    {
        $position = new Position(1, 1);
        $this->assertIsObject($position->get());
    }
}
