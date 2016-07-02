<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\CacheInterface;
use WyriHaximus\Travis\Resource\RepositoryInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop, require 'resolve_key.php');

$repos = [
    'WyriHaximus/php-travis-client',
];

if (count($argv) > 1) {
    unset($argv[0]);
    foreach ($argv as $repo) {
        $repos[] = $repo;
    }
}

foreach ($repos as $repo) {
    $client->repository($repo)->then(function (RepositoryInterface $repo) {
        $repo->caches()->subscribe(new CallbackObserver(function (CacheInterface $cache) {
            echo 'Cache', PHP_EOL;
            echo "\t" . 'branch: ' . $cache->branch(), PHP_EOL;
            echo "\t" . 'slug: ' . $cache->slug(), PHP_EOL;
            echo "\t" . 'size: ' . $cache->size(), PHP_EOL;
        }));
    });
}

$loop->run();
