<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

$repo = $client->repository($argv[1] ?? 'WyriHaximus/php-travis-client');

echo $repo->slug(), ': ', var_export($repo->settings(), true), PHP_EOL;
