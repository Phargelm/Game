<?php
namespace App\EventDispatcher;

use App\Contracts\EventDispatcher\IEvent;

class Event implements IEvent
{
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }
    
    public function getType(): string
    {
        return $this->type;
    }

}

