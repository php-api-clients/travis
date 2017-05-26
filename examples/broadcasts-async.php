<?php declare(strict_types=1);
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\BroadcastInterface;
use React\EventLoop\Factory;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = AsyncClient::create($loop, require 'resolve_key.php');

$client->broadcasts()->subscribe(function (BroadcastInterface $broadcast) {
    resource_pretty_print($broadcast);
}, function ($e) {
    echo (string)$e;
});

$loop->run();
