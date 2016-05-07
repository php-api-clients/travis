<?php

use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\BuildInterface;
use WyriHaximus\Travis\Resource\RepositoryInterface;
use WyriHaximus\Travis\Transport\Factory;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();
$client = new AsyncClient($loop);

$client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->then(function (RepositoryInterface $repository) use ($argv) {
    echo 'Repository: ', PHP_EOL;
    echo 'id: ' . $repository->id(), PHP_EOL;
    echo 'slug: ' . $repository->slug(), PHP_EOL;
    echo 'description: ' . $repository->description(), PHP_EOL;
    echo 'Builds:', PHP_EOL;
    $repository->build($argv[2] ?? 126863927)->then(function (BuildInterface $build) {
        echo "\t", 'Build', PHP_EOL;
        echo "\t\t" . 'id: ' . $build->id(), PHP_EOL;
        echo "\t\t" . 'commit id: ' . $build->commitId(), PHP_EOL;
        echo "\t\t" . 'duration: ' . $build->duration(), PHP_EOL;
    });
});

$loop->run();
