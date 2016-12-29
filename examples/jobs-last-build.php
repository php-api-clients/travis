<?php

use ApiClients\Client\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = Client::create();

$repository = $client->repository($argv[1] ?? 'WyriHaximus/php-travis-client');
$jobs = $repository->build($repository->lastBuildId())->jobs();
foreach ($jobs as $job) {
    echo 'Job', PHP_EOL;
    echo "\t" . 'id: ' . $job->id(), PHP_EOL;
    echo "\t" . 'number: ' . $job->number(), PHP_EOL;
    echo "\t" . 'state: ' . $job->state(), PHP_EOL;
}
