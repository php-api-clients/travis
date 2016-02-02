<?php

use WyriHaximus\Travis\Client;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

echo 'Travis Client Version: ', Client::getVersion(), PHP_EOL;
