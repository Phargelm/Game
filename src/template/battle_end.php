==============BATTLE IS FINISHED=============
<?php if ($parameters['defender']->isDead()) { ?>
Player <?=$parameters['attacker']->getName()?> WINS!!!
=============================================
<?php } else { ?>
Max round: <?=$parameters['round']?> has been REACHED!!!
<?php } ?>