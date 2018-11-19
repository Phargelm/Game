<?php
namespace App\Logger;

use App\Contracts\EventDispatcher\IEventListener;
use App\Contracts\EventDispatcher\IEvent;
use App\Core\CoreEvent;
use src\BattleService\BattleEvent;

class ConsoleLogger implements IEventListener
{
    /**
     * @var string
     */
    private $templatesPath;
    
    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }
    
    public function handleEvent(IEvent $event)
    {
        if ($event instanceof CoreEvent) {
            return $this->handleCoreEvent($event);
        }
        
        if ($event instanceof BattleEvent) {
            return $this->handleBattleEvent($event);
        }
    }
    
    protected function handleBattleEvent(BattleEvent $event)
    {
        if ($event->getType() === BattleEvent::HIT_EVENT) {
            $this->logFromTemplate('hit', [
                'attacker' => $event->getAttacker(),
                'defender' => $event->getDefender(),
                'damage' => $event->getDamage(),
            ]);
        }
        
        if ($event->getType() === BattleEvent::DEFENDER_IS_LUCKY_EVENT) {
            $this->logFromTemplate('defender_lucky', [
                'attacker' => $event->getAttacker(),
                'defender' => $event->getDefender(),
            ]);
        }
        
        if ($event->getType() === BattleEvent::SKILL_IS_USED_EVENT) {
            $this->log('(!) SKILL "' . $event->getSkill()->getName() . '" is used!');
        }
    }
    
    protected function handleCoreEvent(CoreEvent $event)
    {
        if ($event->getType() === CoreEvent::START_OF_THE_BATTLE_EVENT) {
            $this->logFromTemplate('battle_start', [
                'players' => [$event->getAttacker(), $event->getDefender()]
            ]);
        }
        
        if ($event->getType() === CoreEvent::END_OF_THE_BATTLE_EVENT) {
            $this->logFromTemplate('battle_end', [
                'round' => $event->getRound(),
                'attacker' => $event->getAttacker(),
                'defender' => $event->getDefender(),
            ]);
        }
        
        if ($event->getType() === CoreEvent::ROUND_START_EVENT) {
            $this->logFromTemplate('round_start', ['round' => $event->getRound()]);
        }
        
        if ($event->getType() === CoreEvent::ROUND_END_EVENT) {
            $this->log('Round end');
        }
    }
    
    protected function logFromTemplate(string $templateName, array $parameters)
    {
        require $this->templatesPath . DIRECTORY_SEPARATOR . $templateName . '.php';
    }
    
    protected function log(string $message)
    {
        echo $message . PHP_EOL;
    }
}

