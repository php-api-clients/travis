<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client(require 'resolve_key.php');

foreach ($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->caches() as $cache) {
    echo 'Cache', PHP_EOL;
    echo "\t" . 'branch: ' . $cache->branch(), PHP_EOL;
    echo "\t" . 'slug: ' . $cache->slug(), PHP_EOL;
    echo "\t" . 'size: ' . $cache->size(), PHP_EOL;
}
