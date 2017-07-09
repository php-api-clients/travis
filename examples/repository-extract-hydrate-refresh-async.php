<?php declare(strict_types=1);
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use React\EventLoop\Factory;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop   = Factory::create();
$client = AsyncClient::create($loop);

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
    $client->repository($repo)->then(function (RepositoryInterface $repo) use ($client) {
        resource_pretty_print($repo);

        return $client->extract($repo);
    })->then(function (string $json) use ($client) {
        echo $json, PHP_EOL;

        return $client->hydrate($json);
    })->then(function (RepositoryInterface $repo) {
        resource_pretty_print($repo);

        return $repo->refresh();
    })->done(function (RepositoryInterface $repo) {
        resource_pretty_print($repo);
    }, function ($e) {
        echo (string)$e;
    });
}

$loop->run();
