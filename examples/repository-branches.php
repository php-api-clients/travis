<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client(require 'resolve_key.php');

foreach ($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->branches() as $branch) {
    echo 'Branch', PHP_EOL;
    echo "\t" . 'id: ' . $branch->id(), PHP_EOL;
    echo "\t" . 'repository_id: ' . $branch->repositoryId(), PHP_EOL;
    echo "\t" . 'commit_id: ' . $branch->commitId(), PHP_EOL;
}