<?php

use React\EventLoop\Factory;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\Async\Build;
use WyriHaximus\Travis\Resource\Async\Job;
use WyriHaximus\Travis\Resource\Async\Repository;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop);

$client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->then(function (Repository $repository) {
    echo 'Repository: ', PHP_EOL;
    echo 'id: ' . $repository->id(), PHP_EOL;
    echo 'slug: ' . $repository->slug(), PHP_EOL;
    echo 'description: ' . $repository->description(), PHP_EOL;
    echo 'Builds:', PHP_EOL;
    return $repository->build($repository->lastBuildId());
})->then(function (Build $build) use ($argv) {
    echo "\t", 'Build', PHP_EOL;
    echo "\t\t" . 'id: ' . $build->id(), PHP_EOL;
    echo "\t\t" . 'commit id: ' . $build->commitId(), PHP_EOL;
    echo "\t\t" . 'duration: ' . $build->duration(), PHP_EOL;
    return $build->job($argv[2] ?? 128670080);
})->then(function (Job $job) {
    echo "\t\t" . 'Job', PHP_EOL;
    echo "\t\t\t" . 'id: ' . $job->id(), PHP_EOL;
    echo "\t\t\t" . 'number: ' . $job->number(), PHP_EOL;
    echo "\t\t\t" . 'state: ' . $job->state(), PHP_EOL;
});

$loop->run();
