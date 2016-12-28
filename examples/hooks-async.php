<?php

use React\EventLoop\Factory;
use Rx\Observer\CallbackObserver;
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\HookInterface;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = AsyncClient::create($loop, require 'resolve_key.php');

$client->hooks()->subscribe(new CallbackObserver(function (HookInterface $hook) {
    resource_pretty_print($hook);
}));

$loop->run();
