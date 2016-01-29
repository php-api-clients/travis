<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

foreach ($client->repository('WyriHaximus/php-travis-client')->builds() as $build) {
    echo 'Build: #', $build->getId(), PHP_EOL;
    foreach ($build->matrix() as $matri) {
        echo "\t", 'php: ', $matri->getPHP(), PHP_EOL;
        echo "\t", 'env: ', $matri->getEnv(), PHP_EOL;
    }
}
