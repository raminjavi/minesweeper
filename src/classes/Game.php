<?php

declare(strict_types=1);

namespace Game\classes;

class Game
{
    private Board $board;
    private Player $winner;
    private array $players;
    private int $totalMines;
    private int $scoresToWin;
    private array $playedCellsHistory;
    private bool $isGameOver = false;


    /**
     * Create a new Game instance.
     * 
     * @param Board $board
     * @param array $players
     * @param int $totalMines
     * @param int $scoresToWin
     * @return void
     */
    public function __construct(Board $board, array $players, int $totalMines, int $scoresToWin)
    {
        $this->board = $board;
        $this->setScoresToWin($scoresToWin);

        try {
            $this->setPlayers($players);
            $this->setBoardMines($totalMines);
        } catch (\InvalidArgumentException $e) {
            die("Cannot create Game object: " . $e->getMessage());
        }
    }



    /**
     * Add a score to Player;
     * If Player's scores reach to the wining number, 
     * mark Player as winner
     * and end the game.
     * 
     * @param Player $p
     * @return Player $player
     * @throws Exception if Player doesn't exist
     */
    public function addScoreToPlayer(Player $p): Player
    {
        $key = array_search($p, $this->players, true);

        if (empty($this->players[$key])) {
            throw new \Exception("Player doesn't exist in the list of players");
        }

        $player = $this->players[$key];
        $player->addScore(1);

        if ($this->scoresToWin == $player->getScores()) {
            $player->win();
            $this->winner = $player;
            $this->setGameOver();
        }

        return $player;
    }


    /**
     * @return bool
     */
    public function isGameOver(): bool
    {
        return $this->isGameOver;
    }


    /**
     * Finish the game
     * 
     * @return void
     */
    public function setGameOver(): void
    {
        $this->isGameOver = true;
    }


    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }


    /**
     * Finish the game
     * 
     * @param array $players
     * @return array $players
     * @throws InvalidArgumentException if Player has invalid type
     */
    private function setPlayers(array $players): array
    {
        foreach ($players as $player) {
            if (!$player instanceof Player) {
                throw new \InvalidArgumentException("Invalid Player type");
            }
            $this->players[] = $player;
        }
        return $this->players;
    }


    /**
     * @return null|Player
     */
    public function getwinner(): ?Player
    {
        return $this->isGameOver() ? $this->winner : null;
    }


    /**
     * @return int $totalMines
     */
    public function getTotalMines(): int
    {
        return $this->totalMines;
    }


    /**
     * @param int $scoresToWin
     * @return int $scoresToWin
     */
    private function setScoresToWin(int $scoresToWin): int
    {
        return $this->scoresToWin = abs($scoresToWin);
    }


    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }


    /**
     * @return void
     */
    public function addPlayedCellToHistory(Cell $cell): void
    {
        $this->playedCellsHistory[] = $cell;
    }

    /**
     * @return array
     */
    public function getPlayedCellsHistory(): array
    {
        return $this->playedCellsHistory;
    }


    /**
     * Plants Mine in Board
     * 
     * @param int $totalMines
     * @return int $plantedMines
     * @throws LogicException if $totalMines were more than Board cells
     */
    private function setBoardMines(int $totalMines): int
    {
        $this->totalMines = abs($totalMines);

        $board = $this->board;
        $boardCells = $board->getCells();
        $boardDimensions = $board->getDimensions();

        // Since X and Y start from zero, we must increase them by 1
        $board_x = $boardDimensions->x + 1;
        $board_y = $boardDimensions->y + 1;

        if ($this->totalMines > ($board_x * $board_y)) {
            throw new \LogicException("Mines must be less than Board cells");
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
            'totalMines' => $this->totalMines,
            'scoresToWin' => $this->scoresToWin,
            'players' => $this->players,
            'winner' => $this->winner,
            'history' => $this->playedCellsHistory,
        ];
    }

}
