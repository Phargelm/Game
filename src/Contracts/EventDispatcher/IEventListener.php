<?php
namespace App\Contracts\EventDispatcher;

interface IEventListener
{
    public function handleEvent(IEvent $event);
}

