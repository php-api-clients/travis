<?php

use WyriHaximus\Travis\Builds;
use WyriHaximus\Travis\Client;
use WyriHaximus\Travis\Travis;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();
$travis = new Travis($client);

$client->requestAsync($travis->repository('WyriHaximus/php-travis-client')->builds())->then(function ($builds) {
    foreach ($builds as $build) {
        echo 'Build: #', $build->getId(), PHP_EOL;
        /*$build->getClient()->requestAsync($build->matrix())->then(function ($matrix) {
            echo 'Build: #', $matrix->getBuild()->getId(), PHP_EOL;
            foreach ($matrix as $matri) {
                echo "\t", 'php: ', $matri->getPHP(), PHP_EOL;
                echo "\t", 'env: ', $matri->getEnv(), PHP_EOL;
            }
        });*/
    }
});
