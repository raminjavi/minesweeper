<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Game\classes\Board;
use Game\classes\Cell;
use Game\classes\Mine;
use Game\classes\Player;
use Game\classes\Position;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{

    public function testCreateObject(): void
    {
        $cell = self::createMineObject();
        $this->assertInstanceOf(Cell::class, $cell);
    }

    public function testMark(): void
    {
        $player = new Player("John Doe");
        $cell = self::createMineObject();
        $this->assertInstanceOf(Cell::class, $cell->mark($player));
    }


    public function testIsMarked(): void
    {
        $cell = self::createMineObject();
        $this->assertIsBool($cell->isMarked());
    }


    public function testGetPlayer(): void
    {
        $cell = self::createMineObject();
        $this->assertThat($cell->getPlayer(), $this->logicalOr(
            $this->isNull(),
            $this->isInstanceOf(Player::class)
        ));
    }


    public function testMine(): void
    {
        $cell = self::createMineObject();
        $this->assertThat($cell->getMine(), $this->logicalOr(
            $this->isNull(),
            $this->isInstanceOf(Mine::class)
        ));
    }


    public function testGetMinesAround(): void
    {
        $board = new Board(7, 8);
        $cell = self::createMineObject();
        $this->assertIsInt($cell->getMinesAround($board));
    }


    public function testGetPosition(): void
    {
        $cell = self::createMineObject();
        $this->assertInstanceOf(Position::class, $cell->getPosition());
    }


    public function testSetMine(): void
    {
        $mine = new Mine(new Position(1, 1));
        $cell = self::createMineObject();
        $this->assertInstanceOf(Mine::class, $cell->setMine($mine));
    }

    private static function createMineObject(): Cell
    {
        $position = new Position(1, 1);
        return new Cell($position);
    }
}
