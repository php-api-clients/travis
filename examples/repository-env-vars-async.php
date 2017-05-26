<?php

use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\EnvironmentVariableInterface;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use React\EventLoop\Factory;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = AsyncClient::create($loop, require 'resolve_key.php');

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
        $repo->vars()->subscribe(function (EnvironmentVariableInterface $envVar) {
            resource_pretty_print($envVar);
        });
    });
}

$loop->run();
