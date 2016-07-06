<?php

use WyriHaximus\Travis\Client;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = new Client(require 'resolve_key.php');

foreach ($client->accounts() as $account) {
    $account = $account->refresh();
    echo "\t", 'Account', PHP_EOL;
    echo "\t\t" . 'id: ' . $account->id(), PHP_EOL;
    echo "\t\t" . 'login: ' . $account->login(), PHP_EOL;
    echo "\t\t" . 'type: ' . $account->type(), PHP_EOL;
    echo "\t\t" . 'repos_count: ' . $account->reposCount(), PHP_EOL;
}
