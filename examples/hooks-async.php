<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\HookInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop, require 'resolve_key.php');

$client->hooks()->subscribe(new CallbackObserver(function (HookInterface $hook) {
    echo "\t", 'Hook', PHP_EOL;
    echo "\t\t" . 'id: ' . $hook->id(), PHP_EOL;
    echo "\t\t" . 'active: ' . (string)(int)$hook->active(), PHP_EOL;
}));

$loop->run();
