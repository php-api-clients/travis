<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\AccountInterface;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop, require 'resolve_key.php');

$client->accounts()->subscribe(new CallbackObserver(function (AccountInterface $account) {
    $account->refresh()->then(function (AccountInterface $account) {
        echo "\t", 'Account', PHP_EOL;
        echo "\t\t" . 'id: ' . $account->id(), PHP_EOL;
        echo "\t\t" . 'login: ' . $account->login(), PHP_EOL;
        echo "\t\t" . 'type: ' . $account->type(), PHP_EOL;
        echo "\t\t" . 'repos_count: ' . $account->reposCount(), PHP_EOL;
    });
}));

$loop->run();
