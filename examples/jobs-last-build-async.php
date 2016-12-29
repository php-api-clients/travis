<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\Async\Job;
use ApiClients\Client\Travis\Resource\Async\Repository;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop   = Factory::create();
$client = AsyncClient::create($loop);

$jobs = $client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->flatMap(function (Repository $repository) {
    return $repository->jobs($repository->lastBuildId());
});

$jobs->subscribe(new CallbackObserver(function (Job $job) {
    echo 'Job', PHP_EOL;
    echo "\t" . 'id: ' . $job->id(), PHP_EOL;
    echo "\t" . 'number: ' . $job->number(), PHP_EOL;
    echo "\t" . 'state: ' . $job->state(), PHP_EOL;
}));

$loop->run();
