<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

$repository = $client->repository($argv[1] ?? 'WyriHaximus/php-travis-client');
echo 'Repository: ', PHP_EOL;
echo 'id: ' . $repository->id(), PHP_EOL;
echo 'slug: ' . $repository->slug(), PHP_EOL;
echo 'description: ' . $repository->description(), PHP_EOL;
echo 'Builds:', PHP_EOL;
$build = $repository->build($argv[2] ?? 126863927);
echo "\t", 'Build', PHP_EOL;
echo "\t\t" . 'id: ' . $build->id(), PHP_EOL;
echo "\t\t" . 'commit id: ' . $build->commitId(), PHP_EOL;
echo "\t\t" . 'duration: ' . $build->duration(), PHP_EOL;
$job = $build->job($argv[3] ?? 128670080);
echo "\t\t" . 'Job', PHP_EOL;
echo "\t\t\t" . 'id: ' . $job->id(), PHP_EOL;
echo "\t\t\t" . 'number: ' . $job->number(), PHP_EOL;
echo "\t\t\t" . 'state: ' . $job->state(), PHP_EOL;
