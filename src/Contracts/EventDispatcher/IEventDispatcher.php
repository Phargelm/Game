<?php
namespace App\Contracts\EventDispatcher;

interface IEventDispatcher
{
    public function addEventListener(string $eventType, IEventListener $eventListener);
    public function removeEventListener(string $eventType, IEventListener $eventListener);
    public function dispatchEvent(IEvent $event);
}

