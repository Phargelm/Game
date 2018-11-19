<?php
namespace App\Contracts;

interface IBattleService
{
    public function fight();
    
    public function swapPlayers();
    
    public function setDamage(int $damage);
    
    public function getDamage(): int;
    
    public function setAttacker(IPlayer $attacker): self;
    
    public function setDefender(IPlayer $defender): self;
    
    public function getAttacker(): IPlayer;
    
    public function getDefender(): IPlayer;
    
    public function changeDefenderHealth();
}

