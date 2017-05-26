<?php declare(strict_types=1);
use ApiClients\Client\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = Client::create(require 'resolve_key.php');

foreach ($client->accounts() as $account) {
    $account = $account->refresh();
    resource_pretty_print($account);
}
