<?php

use WyriHaximus\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client(require 'resolve_key.php');

foreach ($client->broadcasts() as $broadcast) {
    resource_pretty_print($broadcast);
};
