<?php

use WyriHaximus\Travis\Client;
use function WyriHaximus\ApiClient\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

resource_pretty_print($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client'));
