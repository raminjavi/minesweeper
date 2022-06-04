<?php

declare(strict_types=1);

namespace Game\classes;

use Game\classes\Mine;
use Game\classes\Player;

class Cell
{
    private Mine $mine;
    private Player $player;
    private bool $isMarked = false;
    private int $totalMinesAround = 0;

    public function mark(Player $player): Mine|int
    {
        $this->isMarked = true;
        $this->player = $player;

        if ($mine = $this->getMine()) {
            $player->addToScores(1);
            return $mine;
        }
        return 2;
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

    public function getTotalMinesAround(): int
    {
        return $this->totalMinesAround;
    }



    public function setMine(Mine $mine): Mine
    {
        return $this->mine = $mine;
    }
}
