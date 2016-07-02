<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client(require 'resolve_key.php');

foreach ($client->broadcasts() as $broadcast) {
    echo "\t", 'Broadcast', PHP_EOL;
    echo "\t\t" . 'id: ' . $broadcast->id(), PHP_EOL;
    echo "\t\t" . 'message: ' . $broadcast->message(), PHP_EOL;
};
