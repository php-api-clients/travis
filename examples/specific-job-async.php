<?php

use React\EventLoop\Factory;
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\Async\Build;
use ApiClients\Client\Travis\Resource\Async\Job;
use ApiClients\Client\Travis\Resource\Async\Repository;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop   = Factory::create();
$client = AsyncClient::create($loop);

$client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->flatMap(function (Repository $repository) {
    echo 'Repository: ', PHP_EOL;
    echo 'id: ' . $repository->id(), PHP_EOL;
    echo 'slug: ' . $repository->slug(), PHP_EOL;
    echo 'description: ' . $repository->description(), PHP_EOL;
    echo 'Builds:', PHP_EOL;
    //@todo the takeLast operator is isn't implemented yet in RxPHP, so we need to fake it for now
    return $repository->builds()
        ->toArray()
        ->map(function ($builds) {
            return array_pop($builds);
        });
})->flatMap(function (Build $build) use ($argv) {
    echo "\t", 'Build', PHP_EOL;
    echo "\t\t" . 'id: ' . $build->id(), PHP_EOL;
    echo "\t\t" . 'commit id: ' . $build->commitId(), PHP_EOL;
    echo "\t\t" . 'duration: ' . $build->duration(), PHP_EOL;
    
    return $build->job($argv[2] ?? 128670080);
})->subscribeCallback(function (Job $job) {
    echo "\t\t" . 'Job', PHP_EOL;
    echo "\t\t\t" . 'id: ' . $job->id(), PHP_EOL;
    echo "\t\t\t" . 'number: ' . $job->number(), PHP_EOL;
    echo "\t\t\t" . 'state: ' . $job->state(), PHP_EOL;
});

$loop->run();
