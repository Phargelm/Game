<?php
namespace App;

use App\Contracts\IPlayer;
use App\Contracts\Skill\ISkill;

class Player implements IPlayer
{

    const DEFAULT_NAME = 'NoName';
    
    /**
     * @var array
     */
    protected $skills;

    /**
     * @var int
     */
    protected $health;

    /**
     * @var int
     */
    protected $strength;

    /**
     * @var int
     */
    protected $defence;

    /**
     * @var int
     */
    protected $speed;

    /**
     *
     * @var int
     */
    protected $luck;

    /**
     * @var string
     */
    protected $name;

    public function __construct(int $health, int $strength, int $defence, int $speed, int $luck, string $name = self::DEFAULT_NAME)
    {
        $this->health = $health;
        $this->strength = $strength;
        $this->defence = $defence;
        $this->speed = $speed;
        $this->luck = $luck;
        $this->name = $name;
        $this->skills = [];
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setHealth(int $health): IPlayer
    {
        $this->health = $health;

        if ($this->health < 0) {
            $this->health = 0;
        }

        return $this;
    }
    
    public function addSkill(ISkill $skill): IPlayer
    {
        $this->skills[] = $skill;
        return $this;
    }
    
    public function removeSkill(ISkill $skill): IPlayer
    {
        $key = array_search($skill, $this->skills, true);
        
        if ($key !== false) {
            unset($this->skills[$key]);
        }
        
        return $this;
    }
    
    public function getSkills(): array
    {
        return $this->skills;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getDefence(): int
    {
        return $this->defence;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }

    public function isDead(): bool
    {
        return $this->health == 0;
    }

    public function setName(string $name): IPlayer
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

