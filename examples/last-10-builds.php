<?php

use WyriHaximus\Travis\Client;
use WyriHaximus\Travis\Travis;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();
$travis = new Travis($client);

foreach ($travis->repository('WyriHaximus/php-travis-client')->builds() as $build) {
    echo 'Build: #', $build->getId(), PHP_EOL;
    foreach ($build->matrix() as $job) {
        echo "\t", 'Job: #', $job->getId(), PHP_EOL;
        echo "\t\t", 'php: ', $job->getPHP(), PHP_EOL;
        echo "\t\t", 'env: ', $job->getEnv(), PHP_EOL;
    }
}
