<?php declare(strict_types=1);
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\Async\Repository;
use React\EventLoop\Factory;
use function ApiClients\Tools\Rx\observableFromArray;

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

observableFromArray($repos)
    ->flatMap(function ($repo) use ($client) {
        return $client->repository($repo);
    })
    ->flatMap(function (Repository $repo) {
        echo 'Listening on repository: ', $repo->slug(), PHP_EOL;

        return $repo->events();
    })
    ->subscribe(function (Repository $repo) {
        echo 'Repo: ', $repo->slug(), PHP_EOL;
        echo 'Last build ID: ', $repo->lastBuildId(), PHP_EOL;
        echo 'Last build #: ', $repo->lastBuildNumber(), PHP_EOL;
        echo 'Last build state: ', $repo->lastBuildState(), PHP_EOL;
    });

$loop->run();
