<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use Rx\React\Promise;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\Async\Repository;
use WyriHaximus\Travis\Resource\CommitInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop   = Factory::create();
$client = new AsyncClient($loop);

$client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->then(function (Repository $repository) {
    echo 'Repository: ', PHP_EOL;
    echo 'id: ' . $repository->id(), PHP_EOL;
    echo 'slug: ' . $repository->slug(), PHP_EOL;
    echo 'description: ' . $repository->description(), PHP_EOL;
    echo 'Commits:', PHP_EOL;
    $repository->commits()->subscribe(new CallbackObserver(function (CommitInterface $commit) {
        echo "\t", 'Commit', PHP_EOL;
        echo "\t\t" . 'id: ' . $commit->id(), PHP_EOL;
        echo "\t\t" . 'sha: ' . $commit->sha(), PHP_EOL;
        echo "\t\t" . 'branch: ' . $commit->branch(), PHP_EOL;
        echo "\t\t" . 'message: ' . $commit->message(), PHP_EOL;
    }));
});

$loop->run();
