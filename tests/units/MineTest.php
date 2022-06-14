<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Game\classes\Mine;
use Game\classes\Player;
use Game\classes\Position;
use PHPUnit\Framework\TestCase;

class MineTest extends TestCase
{

    public function testCreateObject(): void
    {
        $this->assertInstanceOf(Mine::class, self::createMineObject());
    }

    public function testIsHidden()
    {
        $mine = self::createMineObject();
        $this->assertIsBool($mine->isHidden());
    }


    public function testGetPosition()
    {
        $mine = self::createMineObject();
        $this->assertInstanceOf(Position::class, $mine->getPosition());
    }


    public function testGetPlayer()
    {
        $mine = self::createMineObject();
        $this->assertThat($mine->getPlayer(), $this->logicalOr(
            $this->isNull(),
            $this->isInstanceOf(Player::class)
        ));
    }

    private static function createMineObject(): Mine
    {
        $position = new Position(1, 1);
        return new Mine($position);
    }
}
