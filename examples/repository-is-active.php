<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

if ($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->isActive()) {
    echo 'Active', PHP_EOL;
} else {
    echo 'Inactive', PHP_EOL;
}
