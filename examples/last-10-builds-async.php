<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

$client->repository('WyriHaximus/php-travis-client')->builds()->then(function ($builds) {
    foreach ($builds as $build) {
        $build->matrix()->then(function ($matrix) {
            echo 'Build: #', $matrix->getBuild()->getId(), PHP_EOL;
            foreach ($matrix as $matri) {
                echo "\t", 'php: ', $matri->getPHP(), PHP_EOL;
                echo "\t", 'env: ', $matri->getEnv(), PHP_EOL;
            }
        });
    }
});
