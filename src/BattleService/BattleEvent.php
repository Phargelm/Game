<?php
namespace src\BattleService;

use App\EventDispatcher\Event;
use App\Contracts\IPlayer;
use App\Contracts\Skill\ISkill;

class BattleEvent extends Event
{
    const HIT_EVENT = 'hitEvent';
    const DEFENDER_IS_LUCKY_EVENT = 'defenderIsLuckyEvent';
    const SKILL_IS_USED_EVENT = 'skillIsUsedEvent';
    
    /**
     * @var IPlayer
     */
    private $attacker;
    
    /**
     * @var IPlayer
     */
    private $defender;
    
    /**
     * @var int
     */
    private $damage;
    
    /**
     * @var ISkill
     */
    private $skill;
    
    public function __construct(
        string $type,
        IPlayer $attacker,
        IPlayer $defender,
        int $damage = 0,
        ISkill $skill = null)
    {
        parent::__construct($type);
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->damage = $damage;
        $this->skill = $skill;
    }
    
    public function getAttacker(): IPlayer
    {
        return $this->attacker;
    }
    
    public function getDefender(): IPlayer
    {
        return $this->defender;
    }
    
    public function getDamage(): int
    {
        return $this->damage;
    }
    
    public function getSkill(): ISkill
    {
        return $this->skill;
    }
}

