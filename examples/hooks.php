<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client(require 'resolve_key.php');

foreach ($client->hooks() as $hook) {
    echo "\t", 'Hook', PHP_EOL;
    echo "\t\t" . 'id: ' . $hook->id(), PHP_EOL;
    echo "\t\t" . 'active: ' . (string)(int)$hook->active(), PHP_EOL;
}
