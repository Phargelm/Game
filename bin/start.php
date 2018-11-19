<?php

use App\Bootstrapper;

require_once __DIR__ . '/../autoloader.php';

/**
 * @var App\Core\Core $core
 */
$core = (new Bootstrapper())->boot();
$core->run();