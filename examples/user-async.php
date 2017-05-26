<?php declare(strict_types=1);
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\UserInterface;
use React\EventLoop\Factory;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = AsyncClient::create($loop, require 'resolve_key.php');

$client->user()->then(function (UserInterface $user) {
    resource_pretty_print($user);
});

$loop->run();
