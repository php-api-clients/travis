<?php

use React\EventLoop\Factory;
use WyriHaximus\Travis\AsyncClient;
use WyriHaximus\Travis\Resource\UserInterface;
use function WyriHaximus\ApiClient\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient($loop, require 'resolve_key.php');

$client->user()->then(function (UserInterface $user) {
    resource_pretty_print($user);
});

$loop->run();
