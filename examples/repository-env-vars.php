<?php

use ApiClients\Client\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = Client::create(require 'resolve_key.php');

foreach ($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->vars() as $envVar) {
    resource_pretty_print($envVar);
}
