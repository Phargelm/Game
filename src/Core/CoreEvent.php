<?php
namespace App\Core;

use App\EventDispatcher\Event;
use App\Contracts\IPlayer;

class CoreEvent extends Event
{
    const START_OF_THE_BATTLE_EVENT = 'startOfTheBattleEvent';
    const END_OF_THE_BATTLE_EVENT = 'endOftheBattleEvent';
    const ROUND_START_EVENT = 'roundStartEvent';
    const ROUND_END_EVENT = 'roundEndEvent';
    
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
    private $round;
    
    public function __construct(string $type, IPlayer $attacker, IPlayer $defender, int $round = 0)
    {
        parent::__construct($type);
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->round = $round;
    }
    
    public function getAttacker(): IPlayer
    {
        return $this->attacker;
    }
    
    public function getDefender(): IPlayer
    {
        return $this->defender;
    }
    
    public function getRound()
    {
        return $this->round;
    }
}

