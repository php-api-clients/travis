<?php declare(strict_types=1);
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\AccountInterface;
use React\EventLoop\Factory;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = AsyncClient::create($loop, require 'resolve_key.php');

$client->accounts()->subscribe(function (AccountInterface $account) {
    $account->refresh()->then(function (AccountInterface $account) {
        resource_pretty_print($account);
    });
});

$loop->run();
