<?php declare(strict_types=1);
use ApiClients\Client\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = Client::create(require 'resolve_key.php');

foreach ($client->broadcasts() as $broadcast) {
    resource_pretty_print($broadcast);
};
