<?php

use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\RepositoryInterface;
use WyriHaximus\Travis\Transport\Factory;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();
$client = new AsyncClient(Factory::create($loop));

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
        var_export($repo);
    });
}

$loop->run();
