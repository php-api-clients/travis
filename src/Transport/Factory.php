<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Transport;

use Aws\Handler\GuzzleV6\GuzzleHandler;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use React\EventLoop\Factory as LoopFactory;
use React\EventLoop\LoopInterface;
use WyriHaximus\React\GuzzlePsr7\HttpClientAdapter;

class Factory
{
    public static function create(LoopInterface $loop = null, array $options = []): Client
    {
        if (!($loop instanceof LoopInterface)) {
            $loop = LoopFactory::create();
        }

        return new Client(
            $loop,
            new GuzzleHandler(
                new GuzzleClient(
                    [
                        'handler' => HandlerStack::create(
                            new HttpClientAdapter($loop)
                        ),
                    ]
                )
            ),
            $options
        );
    }
}
