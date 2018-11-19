<?php
namespace App\Contracts;

use App\Contracts\Skill\ISkill;

interface IPlayer
{

    public function getHealth(): int;

    public function getStrength(): int;

    public function getDefence(): int;

    public function getSpeed(): int;

    public function getLuck(): int;

    public function getName(): string;

    public function isDead(): bool;

    public function setHealth(int $health): self;
    
    public function addSkill(ISkill $skill): self;
    
    public function removeSkill(ISkill $skill): IPlayer;
    
    public function getSkills(): array;
    
    public function setName(string $name): self;
}

