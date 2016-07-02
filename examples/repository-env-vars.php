<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client(require 'resolve_key.php');

foreach ($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->vars() as $cache) {
    echo 'Environment variable', PHP_EOL;
    echo "\t" . 'id: ' . $var->id(), PHP_EOL;
    echo "\t" . 'name: ' . $var->name(), PHP_EOL;
    echo "\t" . 'public: ' . (string)$var->public(), PHP_EOL;
}
