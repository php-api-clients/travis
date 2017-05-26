<?php declare(strict_types=1);
use ApiClients\Client\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = Client::create(require 'resolve_key.php');

if ($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->isActive()) {
    echo 'Active', PHP_EOL;
} else {
    echo 'Inactive', PHP_EOL;
}
