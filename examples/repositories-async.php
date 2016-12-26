<?php declare(strict_types=1);

use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Foundation\Options;
use ApiClients\Foundation\Pool\Middleware\PoolMiddleware;
use ApiClients\Foundation\Transport\Options as TransportOptions;
use React\EventLoop\Factory;
use ResourcePool\Pool;
use Rx\Observer\CallbackObserver;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = new AsyncClient(
    $loop,
    require 'resolve_key.php',
    [
        Options::TRANSPORT_OPTIONS => [
            TransportOptions::DEFAULT_REQUEST_OPTIONS => [
                PoolMiddleware::class => [
                    \ApiClients\Foundation\Pool\Options::POOL => new Pool(1),
                ],
            ],
            TransportOptions::MIDDLEWARE => [
                PoolMiddleware::class,
            ],
        ],
    ]
);

$client->repositories()->subscribe(new CallbackObserver(
    function (RepositoryInterface $repository) {
        resource_pretty_print($repository);
    },
    function ($e) {
        echo (string)$e, PHP_EOL;
    },
    function () {
        echo 'Done!', PHP_EOL;
    }
));

$loop->run();
