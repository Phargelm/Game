<?php
namespace App;

use App\BattleService\BattleService;
use App\Core\Core;
use App\Contracts\IBattleService;
use App\Contracts\IPlayer;
use App\EventDispatcher\EventDispatcher;
use App\Core\CoreEvent;
use App\Logger\ConsoleLogger;
use src\BattleService\BattleEvent;
use App\Contracts\EventDispatcher\IEventDispatcher;

class Bootstrapper
{
    private $config;
    
    /**
     * @var IBattleService
     */
    private $battleService;
    
    /**
     * @var IEventDispatcher
     */
    private $eventDispatcher;
    
    public function boot()
    {
        $this->config = require_once __DIR__ . '/../config.php';
        
        $this->eventDispatcher = new EventDispatcher();
        
        $consoleLogger = new ConsoleLogger(__DIR__ . '/template');
        $this->eventDispatcher->addEventListener(CoreEvent::ROUND_START_EVENT, $consoleLogger);
        $this->eventDispatcher->addEventListener(CoreEvent::ROUND_END_EVENT, $consoleLogger);
        $this->eventDispatcher->addEventListener(CoreEvent::START_OF_THE_BATTLE_EVENT, $consoleLogger);
        $this->eventDispatcher->addEventListener(CoreEvent::END_OF_THE_BATTLE_EVENT, $consoleLogger);
        $this->eventDispatcher->addEventListener(BattleEvent::DEFENDER_IS_LUCKY_EVENT, $consoleLogger);
        $this->eventDispatcher->addEventListener(BattleEvent::HIT_EVENT, $consoleLogger);
        $this->eventDispatcher->addEventListener(BattleEvent::SKILL_IS_USED_EVENT, $consoleLogger);
        
        $this->setupBattleService();
        
        return new Core(
            $this->battleService,
            $this->eventDispatcher,
            $this->config['main']['rounds']
        );
    }
    
    private function setupBattleService()
    {
        $this->battleService = new BattleService($this->eventDispatcher);
        
        $firstPlayer = $this->setupPlayer($this->config['players']['first_player']);
        $secondPlayer = $this->setupPlayer($this->config['players']['second_player']);
                
        $attacker = $this->chooseAttacker($firstPlayer, $secondPlayer);
        $defender = $firstPlayer === $attacker ? $secondPlayer: $firstPlayer;
        
        $this->battleService->setAttacker($attacker);
        $this->battleService->setDefender($defender);
    }
    
    private function setupPlayer(array $config): IPlayer
    {
        $player = new Player(
            rand($config['health']['min'], $config['health']['max']),
            rand($config['strength']['min'], $config['strength']['max']),
            rand($config['defence']['min'], $config['defence']['max']),
            rand($config['speed']['min'], $config['speed']['max']),
            rand($config['luck']['min'], $config['luck']['max']),
            $config['name']
        );
        
        /**
         * @var $skillConfig array
         */
        foreach($config['skills'] as $skillConfig) {
            
            if (!class_exists($skillConfig['name'])) {
                continue;
            }
            
            $skill = new $skillConfig['name']($this->battleService, $skillConfig['chance']);
            $player->addSkill($skill);
        }
        
        return $player;
    }
    
    private function chooseAttacker(IPlayer $firstPlayer, IPlayer $secondPlayer): IPlayer
    {
        // try to choose attacker by speed
        if ($firstPlayer->getSpeed() > $secondPlayer->getSpeed()) {
            return $firstPlayer;
        }
        
        if ($firstPlayer->getSpeed() < $secondPlayer->getSpeed()) {
            return $secondPlayer;
        }
        
        //both players have the same speed, try to choose by luck
        if ($firstPlayer->getLuck() > $secondPlayer->getLuck()) {
            return $firstPlayer;
        }
        
        if ($firstPlayer->getLuck() < $secondPlayer->getLuck()) {
            return $secondPlayer;
        }
        
        //both players have the same speed and luck, try to choose randomly
        return rand(0, 1) ? $firstPlayer : $secondPlayer;
    }
}
