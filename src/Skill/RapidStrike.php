<?php
namespace App\Skill;

use src\Contracts\Skill\IAttackSkill;

class RapidStrike extends Skill implements IAttackSkill
{
    const NAME = 'Rapid Strike';

    public function getName(): string
    {
        return static::NAME;
    }

    public function apply()
    {
        $this->battleService->changeDefenderHealth();
    }
}

