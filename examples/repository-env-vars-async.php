<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\CacheInterface;
use WyriHaximus\Travis\Resource\EnvironmentVariableInterface;
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
        $repo->vars()->subscribe(new CallbackObserver(function (EnvironmentVariableInterface $var) {
            echo 'Environment variable', PHP_EOL;
            echo "\t" . 'id: ' . $var->id(), PHP_EOL;
            echo "\t" . 'name: ' . $var->name(), PHP_EOL;
            echo "\t" . 'public: ' . (string)$var->public(), PHP_EOL;
        }));
    });
}

$loop->run();
