<?php

spl_autoload_register(function ($class) {
    
    if (strpos($class, 'App') == 0) {
        $class = str_replace('App', 'src', $class);
    }
    
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    require __DIR__ . DIRECTORY_SEPARATOR . $class . ".php";
});