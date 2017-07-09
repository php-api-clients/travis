<?php declare(strict_types=1);
use ApiClients\Client\Travis\Client;
use React\EventLoop\Factory;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = Client::create();

$repos = [
    'WyriHaximus/php-travis-client',
];

if (count($argv) > 1) {
    unset($argv[0]);
    foreach ($argv as $repo) {
        $repos[] = $repo;
    }
}

foreach ($repos as $repo) {
    $repo = $client->repository($repo);
    resource_pretty_print($repo);

    $json = $client->extract($repo);
    echo $json, PHP_EOL;

    $repo = $client->hydrate($json);
    resource_pretty_print($repo);

    $repo = $repo->refresh();
    resource_pretty_print($repo);
}
