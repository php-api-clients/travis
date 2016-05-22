<?php

use React\EventLoop\Factory;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\RepositoryInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop   = Factory::create();
$client = new AsyncClient($loop);

$repos = [
    'WyriHaximus/php-travis-client',
];

if (count($argv) > 1) {
    unset($argv[0]);
    foreach ($argv as $repo) {
        $repos[] = $repo;
    }
}

$repos = \Rx\Observable::fromArray($repos);

$repo = $repos->flatMap(function ($repo) use ($client) {
    return $client->repository($repo);
});

$repo->subscribeCallback(function (RepositoryInterface $repo) {
    var_export($repo);
});


$loop->run();
