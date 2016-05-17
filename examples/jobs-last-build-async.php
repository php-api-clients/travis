<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\Async\Build;
use WyriHaximus\Travis\Resource\Async\Job;
use WyriHaximus\Travis\Resource\Async\Repository;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop);

$client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->then(function (Repository $repository) {
    return $repository->build($repository->lastBuildId());
})->then(function (Build $build) {
    $build->jobs()->subscribe(new CallbackObserver(function (Job $job) {
        echo 'Job', PHP_EOL;
        echo "\t" . 'id: ' . $job->id(), PHP_EOL;
        echo "\t" . 'number: ' . $job->number(), PHP_EOL;
        echo "\t" . 'state: ' . $job->state(), PHP_EOL;
    }));
});

$loop->run();
