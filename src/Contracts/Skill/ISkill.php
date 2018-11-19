<?php
namespace App\Contracts\Skill;

interface ISkill
{
    public function getChance(): int;
    public function getName(): string;
    public function apply();
}

