<?php

use WyriHaximus\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

$repo = $client->repository($argv[1] ?? 'WyriHaximus/php-travis-client');
resource_pretty_print($repo);
resource_pretty_print($repo->refresh());
