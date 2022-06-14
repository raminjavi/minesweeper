<?php

declare(strict_types=1);

namespace Game\classes;

class Mine
{
    private Player $player;
    private Position $position;
    private bool $isHidden = true;


    /**
     * Create a new Mine instance.
     * 
     * @param Position $position
     * @return void
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
    }


    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->isHidden;
    }


    /**
     * @param Player $player
     * @return void
     */
    public function find(Player $player): void
    {
        $this->isHidden = false;
        $this->player = $player;
    }


    /**
     * @return Player|null
     */
    public function getPlayer(): ?Player
    {
        return isset($this->player) ? $this->player : null;
    }


    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }
}
