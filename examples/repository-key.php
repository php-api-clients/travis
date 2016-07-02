<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client();

var_export($client->repository($argv[1] ?? 'WyriHaximus/php-travis-client')->key());
