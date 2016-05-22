<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler\EventLoopScheduler;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\Async\Repository;
use WyriHaximus\Travis\Resource\RepositoryInterface;
use function EventLoop\getLoop;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
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

foreach ($repos as $repo) {
    $client->repository($repo)->then(function (Repository $repo) {
        echo 'Repo: ', $repo->slug(), PHP_EOL;
        $repo->subscribe()->subscribe(new CallbackObserver(function (Repository $repo) {
            echo 'Last build ID: ', $repo->lastBuildId(), PHP_EOL;
            echo 'Last build state: ', $repo->lastBuildState(), PHP_EOL;
        }));
    });
}

$loop->run();
