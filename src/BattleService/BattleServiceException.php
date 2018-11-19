<?php
namespace App\BattleService;

class BattleServiceException extends \RuntimeException
{
    const ATTACKER_IS_DEAD_CODE = 0;
    const DEFENDER_IS_DEAD_CODE = 1;
}

