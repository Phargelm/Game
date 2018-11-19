<?php
namespace App\Skill;

use App\Contracts\Skill\ISkill;
use App\Contracts\IBattleService;

abstract class Skill implements ISkill
{
    
    /**
     * @var IBattleService
     */
    protected $battleService;
    /**
     * @var int
     */
    protected $chance;
    
    public function __construct(IBattleService $battleService, int $chance)
    {
        $this->battleService = $battleService;
        $this->chance = $chance;
    }
    
    public function getChance():int
    {
        return $this->chance;
    }
}