<?php

declare(strict_types=1);

namespace Game\classes;

class GameState
{
    private Board $board;
    private Player $winer;
    private array $players;
    private bool $isGameOver = false;
    // private $totalScores = 0;

    public function __construct(Board $board, array $players)
    {
        $this->board = $board;
        $this->setPlayers($players);
    }

    public function isPositionPlayable(Position $position): bool
    {
        $cell = $this->board->getCell($position);
        return !$cell->isMarked();
    }

    public function addScoreToPlayer(Player $player): Player
    {
        foreach ($this->players as $key => $item) {
            if ($player == $item) {

                $p = $this->players[$key];

                if ($this->board->getTotalScores() == $p->getTotalScores()) {
                    $this->winer = $p;
                    $this->setGameOver();
                }

                $p->addScore(1);

                return $p;
            }
        }
    }

    public function isGameOver(): bool
    {
        return $this->isGameOver;
    }

    public function setGameOver(): void
    {
        $this->isGameOver = true;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    private function setPlayers(array $players): array
    {
        $playersArray = [];
        foreach ($players as $player) {
            if (!$player instanceof Player) {
                throw new \Exception("Invalid Player type");
            }
            $playersArray[] = $player;
        }
        $this->players = $playersArray;
        return $this->players;
    }

    public function getWiner(): ?Player
    {
        if ($this->isGameOver()) {
            return $this->winer;
        }
        return null;
    }

    // public function getTotalScores(): int
    // {
    //     return $this->totalScores;
    // }
}
