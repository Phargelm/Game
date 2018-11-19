<?php
namespace App\Core;

use App\Contracts\IBattleService;
use App\Contracts\EventDispatcher\IEventDispatcher;

class Core
{

    /**
     * @var IBattleService
     */
    private $battleService;
    
    /**
     * @var IEventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var int
     */
    private $maxRounds;

    public function __construct(
        IBattleService $battleService,
        IEventDispatcher $eventDispatcher,
        int $maxRounds
    )
    {
        $this->battleService = $battleService;
        $this->eventDispatcher = $eventDispatcher;
        $this->maxRounds = $maxRounds;
    }

    public function run()
    {
        $this->dispatchCoreEvent(CoreEvent::START_OF_THE_BATTLE_EVENT);
        
        for ($i = 0; $i < $this->maxRounds; $i++) {
            
            $this->dispatchCoreEvent(CoreEvent::ROUND_START_EVENT, $i + 1);
            
            $this->battleService->fight();
            
            $this->dispatchCoreEvent(CoreEvent::ROUND_END_EVENT, $i + 1);
            
            if ($this->battleService->getDefender()->isDead()) {
                break;
            }
            
            $this->battleService->swapPlayers();
            //readline("Press <Enter> button for the next round...");
        }
        
        $this->dispatchCoreEvent(CoreEvent::END_OF_THE_BATTLE_EVENT, $i);
    }
    
    private function dispatchCoreEvent(string $type, int $round = 0)
    {
        $event = new CoreEvent(
            $type, $this->battleService->getAttacker(),
            $this->battleService->getDefender(), $round
        );
        
        $this->eventDispatcher->dispatchEvent($event);
    }
}

