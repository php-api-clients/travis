<?php

use WyriHaximus\Travis\Client;
use WyriHaximus\Travis\Travis;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();
$travis = new Travis($client);

$builds = $client->request($travis->repository('WyriHaximus/php-travis-client')->builds());
foreach ($builds as $build) {
    echo 'Build: #', $build->getId(), PHP_EOL;
    /*foreach ($build->getClient()->request($build->matrix()) as $matri) {
        echo "\t", 'php: ', $matri->getPHP(), PHP_EOL;
        echo "\t", 'env: ', $matri->getEnv(), PHP_EOL;
    }*/
}
