<?php declare(strict_types=1);

use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Foundation\Options;
use ApiClients\Foundation\Transport\Options as TransportOptions;
use ApiClients\Middleware\Delay\DelayMiddleware;
use ApiClients\Middleware\Pool\PoolMiddleware;
use React\EventLoop\Factory;
use ResourcePool\Pool;
use Rx\Observer\CallbackObserver;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$loop = Factory::create();
$client = AsyncClient::create(
    $loop,
    require 'resolve_key.php',
    [ // We're passing these extra options to ensure we don't request all repositories at once (!!!)
        Options::TRANSPORT_OPTIONS => [
            TransportOptions::DEFAULT_REQUEST_OPTIONS => [
                PoolMiddleware::class => [
                    \ApiClients\Middleware\Pool\Options::POOL => new Pool(1),
                ],
                DelayMiddleware::class => [
                    \ApiClients\Middleware\Delay\Options::DELAY => 3,
                ],
            ],
            TransportOptions::MIDDLEWARE => [
                PoolMiddleware::class,
                DelayMiddleware::class,
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
