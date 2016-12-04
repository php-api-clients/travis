<?php

use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\Async\Repository;
use ApiClients\Client\Travis\Resource\BuildInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();
$client = new AsyncClient($loop);

$client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->subscribeCallback(function (Repository $repository) use ($argv) {
    echo 'Repository: ', PHP_EOL;
    echo 'id: ' . $repository->id(), PHP_EOL;
    echo 'slug: ' . $repository->slug(), PHP_EOL;
    echo 'description: ' . $repository->description(), PHP_EOL;
    echo 'Builds:', PHP_EOL;
    $repository->build($argv[2] ?? 126863927)->subscribeCallback(function (BuildInterface $build) {
        echo "\t", 'Build', PHP_EOL;
        echo "\t\t" . 'id: ' . $build->id(), PHP_EOL;
        echo "\t\t" . 'commit id: ' . $build->commitId(), PHP_EOL;
        echo "\t\t" . 'duration: ' . $build->duration(), PHP_EOL;
    });
});

$loop->run();
