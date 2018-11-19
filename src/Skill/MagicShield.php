<?php
namespace App\Skill;

use App\Contracts\Skill\IDefenceSkill;

class MagicShield extends Skill implements IDefenceSkill
{
    const NAME = 'Magic Shield';
    const MULTIPLIER = 0.5;
    
    public function apply()
    {
        $damage = $this->battleService->getDamage();
        $this->battleService->setDamage((int) ($damage * static::MULTIPLIER));
    }
    
    public function getName(): string
    {
        return static::NAME;
    }

}