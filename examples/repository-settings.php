<?php

use WyriHaximus\Travis\Client;
use function WyriHaximus\ApiClient\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

$repo = $client->repository($argv[1] ?? 'WyriHaximus/php-travis-client');

echo $repo->slug(), ': ', PHP_EOL;
resource_pretty_print($repo->settings(), 1);
