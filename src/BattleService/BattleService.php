<?php
namespace App\BattleService;

use App\Contracts\IPlayer;
use App\Contracts\IBattleService;
use App\Contracts\EventDispatcher\IEventDispatcher;
use src\BattleService\BattleEvent;
use App\Contracts\Skill\IDefenceSkill;
use App\Contracts\Skill\ISkill;
use src\Contracts\Skill\IAttackSkill;

class BattleService implements IBattleService
{

    /**
     * @var IEventDispatcher
     */
    private $eventDispatcher;
    
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

    public function __construct(
        IEventDispatcher $eventDispatcher,
        IPlayer $attacker = null,
        IPlayer $defender = null)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->attacker = $attacker;
        $this->defender = $defender;
    }

    public function fight()
    {
        $this->damage = 0;
        if (!$this->attacker || $this->attacker->isDead()) {
            
            throw new BattleServiceException(
                'The fight can\'t be performed, because attacker is not exists or dead.',
                BattleServiceException::ATTACKER_IS_DEAD_CODE
            );
        }
        
        if (!$this->defender || $this->defender->isDead()) {
            
            throw new BattleServiceException(
                'The fight can\'t be performed, because defender is not exists or dead.',
                BattleServiceException::DEFENDER_IS_DEAD_CODE
            );
        }
        
        if ($this->isDefenderLucky()) {
            $this->dispatchBattleEvent(BattleEvent::DEFENDER_IS_LUCKY_EVENT);
            return;
        }
        
        $this->calculateDamage();
        $this->changeDefenderHealth();
    }

    public function swapPlayers()
    {
        $previousAttacker = $this->attacker;
        $this->attacker = $this->defender;
        $this->defender = $previousAttacker;
    }

    public function setAttacker(IPlayer $attacker): IBattleService
    {
        $this->attacker = $attacker;
        return $this;
    }

    public function setDefender(IPlayer $defender): IBattleService
    {
        $this->defender = $defender;
        return $this;
    }

    public function getAttacker(): IPlayer
    {
        return $this->attacker;
    }

    public function getDefender(): IPlayer
    {
        return $this->defender;
    }
    
    public function setDamage(int $damage)
    {
        if ($damage < 0) {
            $damage = 0;
        }
        
        return $this->damage = $damage;
    }
    
    public function getDamage(): int
    {
        return $this->damage;
    }
    
    public function changeDefenderHealth()
    {
        $this->defender->setHealth($this->defender->getHealth() - $this->damage);
        $this->dispatchBattleEvent(BattleEvent::HIT_EVENT);
    }
    
    private function isDefenderLucky(): bool
    {
        return mt_rand(0, 100) < $this->defender->getLuck();
    }
    
    private function calculateDamage()
    {
        $this->setDamage($this->attacker->getStrength() - $this->defender->getDefence());
        
        /**
         * @var $skill ISkill
         */
        foreach($this->defender->getSkills() as $skill) {
            
            if (!($skill instanceof IDefenceSkill) || rand(1, 100) > $skill->getChance()) {
                continue;
            }
            
            $skill->apply();
            $this->dispatchBattleEvent(BattleEvent::SKILL_IS_USED_EVENT, $skill);
        }
        
        /**
         * @var $skill ISkill
         */
        foreach($this->attacker->getSkills() as $skill) {
            
            if (!($skill instanceof IAttackSkill) || rand(1, 100) > $skill->getChance()) {
                continue;
            }
            
            $skill->apply();
            $this->dispatchBattleEvent(BattleEvent::SKILL_IS_USED_EVENT, $skill);
        }
    }
    
    private function dispatchBattleEvent(string $type, ISkill $skill = null)
    {
        $event = new BattleEvent($type, $this->attacker, $this->defender, $this->damage, $skill);
        $this->eventDispatcher->dispatchEvent($event);
    }
}

