<?php
namespace App\Contracts\EventDispatcher;

interface IEvent
{
    public function getType(): string;
}

