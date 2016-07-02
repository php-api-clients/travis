<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\BroadcastInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop, require 'resolve_key.php');

$client->broadcasts()->subscribe(new CallbackObserver(function (BroadcastInterface $broadcast) {
    echo "\t", 'Broadcast', PHP_EOL;
    echo "\t\t" . 'id: ' . $broadcast->id(), PHP_EOL;
    echo "\t\t" . 'message: ' . $broadcast->message(), PHP_EOL;
}));

$loop->run();
