<?php
namespace App\EventDispatcher;

use App\Contracts\EventDispatcher\IEventDispatcher;
use App\Contracts\EventDispatcher\IEventListener;
use App\Contracts\EventDispatcher\IEvent;

class EventDispatcher implements IEventDispatcher
{
    /**
     * @var array
     */
    private $eventListeners = [];
    
    public function addEventListener(string $eventType, IEventListener $eventListener)
    {
        if (!isset($this->eventListeners[$eventType])) {
            $this->eventListeners[$eventType] = [];
        }
        
        $this->eventListeners[$eventType][] = $eventListener;
    }
    
    public function removeEventListener(string $eventType, IEventListener $eventListener)
    {
        if (empty($this->eventListeners[$eventType])) {
            return;
        }
        
        $key = array_search($eventListener, $this->eventListeners[$eventType], true);
        
        if ($key === false) {
            return;
        }
        
        unset($this->eventListeners[$eventType][$key]);
    }
    
    public function dispatchEvent(IEvent $event)
    {
        if (empty($this->eventListeners[$event->getType()])) {
            return;
        }
        
        $eventListeners = $this->eventListeners[$event->getType()];
        
        /**
         * @var $listener IEventListener
         */
        foreach ($eventListeners as $listener) {
            $listener->handleEvent($event);
        }
    }
    
}

