<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\BranchInterface;
use WyriHaximus\Travis\Resource\RepositoryInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop, require 'resolve_key.php');

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
        $repo->branches()->subscribe(new CallbackObserver(function (BranchInterface $branch) {
            echo 'Branch', PHP_EOL;
            echo "\t" . 'id: ' . $branch->id(), PHP_EOL;
            echo "\t" . 'repository_id: ' . $branch->repositoryId(), PHP_EOL;
            echo "\t" . 'commit_id: ' . $branch->commitId(), PHP_EOL;
        }));
    });
}

$loop->run();