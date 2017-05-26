<?php declare(strict_types=1);
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use React\EventLoop\Factory;

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
        $repo->isActive()->then(function () use ($repo) {
            echo $repo->slug(), ': Active', PHP_EOL;
        }, function () use ($repo) {
            echo $repo->slug(), ': Inactive', PHP_EOL;
        });
    });
}

$loop->run();
