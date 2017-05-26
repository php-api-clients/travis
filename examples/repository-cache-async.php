<?php

use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\CacheInterface;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use React\EventLoop\Factory;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = AsyncClient::create($loop, require 'resolve_key.php');

$repos = [
    'php-api-clients/travis',
];

if (count($argv) > 1) {
    unset($argv[0]);
    foreach ($argv as $repo) {
        $repos[] = $repo;
    }
}

foreach ($repos as $repo) {
    $client->repository($repo)->then(function (RepositoryInterface $repo) {
        $cacheSize = 0;
        $cacheCount = 0;
        $repo->caches()->subscribe(function (CacheInterface $cache) use (&$cacheSize, &$cacheCount) {
            resource_pretty_print($cache);
            $cacheSize += $cache->size();
            $cacheCount++;
        }, null, function () use ($repo, &$cacheSize, &$cacheCount) {
            echo $repo->slug(), PHP_EOL;
            echo "\t", 'Size: ', round($cacheSize / 1024 / 1024), 'MB', PHP_EOL;
            echo "\t", 'Count: ', $cacheCount, PHP_EOL;
            echo "\t", 'Average Size: ', round(($cacheCount === 0 ? 0 : $cacheSize / $cacheCount) / 1024 / 1024), 'MB', PHP_EOL;
        });
    });
}

$loop->run();
