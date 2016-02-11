<?php

use Aws\Handler\GuzzleV6\GuzzleHandler;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use React\EventLoop\Factory;
use WyriHaximus\React\GuzzlePsr7\HttpClientAdapter;
use WyriHaximus\Travis\BuildCollection;
use WyriHaximus\Travis\Builds;
use WyriHaximus\Travis\Client;
use WyriHaximus\Travis\ApiClient;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();

$client = new Client(new GuzzleHandler(new GuzzleClient([
    'handler' => HandlerStack::create(new HttpClientAdapter($loop)),
])));
$travis = new ApiClient($client);
$travis->repository('WyriHaximus/php-travis-client')->builds()->then(function (BuildCollection $builds) {
    foreach ($builds as $build) {
        //echo 'Build: #', $build->getId(), PHP_EOL;
        $build->matrix()->then(function ($matrix) {
            echo 'Build: #', $matrix->getBuild()->getId(), PHP_EOL;
            foreach ($matrix as $job) {
                echo "\t", 'Job: #', $job->getId(), PHP_EOL;
                echo "\t\t", 'php: ', $job->getPHP(), PHP_EOL;
                echo "\t\t", 'env: ', $job->getEnv(), PHP_EOL;
            }
        });
    }
});

$loop->run();
