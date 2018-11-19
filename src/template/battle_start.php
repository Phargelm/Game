==============PLAYERS STATS================

<?php
/**
 * @var $player App\Contracts\IPlayer
 */
foreach($parameters['players'] as $player) {
?>
	Player <?= $player->getName(); ?>:
	* Health: <?= $player->getHealth(); ?>	
	* Strength: <?= $player->getStrength(); ?>	
	* Defence: <?= $player->getDefence(); ?>	
	* Speed: <?= $player->getSpeed(); ?>	
	* Luck: <?= $player->getLuck(); ?>	
	
<?php
}
?>
==============BATTLE IS STARTED=============

