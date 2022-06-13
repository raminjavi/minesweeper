<?php

declare(strict_types=1);

namespace Game\classes;

class Game
{
    private Board $board;
    private Player $winner;
    private array $players;
    private int $totalMines;
    private int $totalScores;
    private bool $isGameOver = false;


    public function __construct(Board $board, array $players, int $totalMines, int $totalScores)
    {
        $this->board = $board;
        $this->setBoardMines($totalMines);
        $this->setTotalScores($totalScores);
        $this->setPlayers($players);
    }


    public function addScoreToPlayer(Player $p): Player
    {
        $key = array_search($p, $this->players, true);

        if (empty($this->players[$key])) {
            throw new \Exception("Player not found in the game players list");
        }

        $player = $this->players[$key];
        $player->addScore(1);

        if ($this->totalScores == $player->getScores()) {
            $player->win();
            $this->winner = $player;
            $this->setGameOver();
        }

        return $player;
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
        foreach ($players as $player) {
            if (!$player instanceof Player) {
                throw new \Exception("Invalid Player type");
            }
            $this->players[] = $player;
        }
        return $this->players;
    }


    public function getwinner(): ?Player
    {
        return $this->isGameOver() ? $this->winner : null;
    }


    /**
     * Get total mines in the board
     * @return int $totalMines
     */
    public function getTotalMines(): int
    {
        return $this->totalMines;
    }


    /**
     * Get total scores
     * @return int $totalScores
     */
    public function getTotalScores(): int
    {
        return $this->totalScores;
    }

    private function setTotalScores(int $totalScores): int
    {
        return $this->totalScores = abs($totalScores);
        // return $this->totalScores = abs($totalScores - 1);
    }

    public function getBoard(): Board
    {
        return $this->board;
    }


    private function setBoardMines(int $totalMines): int
    {
        $this->totalMines = abs($totalMines);

        $board = $this->board;
        $boardCells = $board->getCells();
        $boardDimensions = $board->getDimensions();

        // Since X and Y start from zero, we must increase them by 1
        $x = $boardDimensions->x + 1;
        $y = $boardDimensions->y + 1;

        if ($this->totalMines > ($x * $y)) {
            throw new \Exception("Mines must be less than Board cells");
        }

        $plantedMines = 0;
        while ($plantedMines < $this->totalMines) {
            if (rand(0, 100) % 2) {
                $randomY = rand(0, $boardDimensions->y);
                $randomX = rand(0, $boardDimensions->x);
                $cell = $boardCells[$randomY][$randomX];
                if (!$cell->getMine()) {
                    $mine = new Mine;
                    $cell->setMine($mine);
                    $plantedMines++;
                }
            }
        }
        return $plantedMines;
    }

    public function getResult(): array
    {
        return [
            'winner' => $this->winner,
            'players' => $this->players,
            'totalMines' => $this->totalMines,
            'totalScores' => $this->totalScores,
        ];
    }

    // public function isPositionPlayable(Position $position): bool
    // {
    //     try {
    //         $cell = $this->board->getCell($position);
    //     } catch (\OutOfRangeException $e) {
    //         return false;
    //     }

    //     return !$cell->isMarked();
    // }
}
