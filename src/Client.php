<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\EventLoop\Factory as LoopFactory;
use WyriHaximus\Travis\Resource\Sync\Repository;
use WyriHaximus\Travis\Transport\Client as Transport;
use WyriHaximus\Travis\Transport\Factory;
use function Clue\React\Block\await;
use function React\Promise\resolve;

class Client
{
    protected $transport;
    protected $client;

    public function __construct(Transport $transport = null)
    {
        $loop = LoopFactory::create();
        if (!($transport instanceof Transport)) {
            $transport = Factory::create($loop, [
                'resource_namespace' => 'Sync',
            ]);
        }
        $this->transport = $transport;
        $this->client = new AsyncClient($loop, $this->transport);
    }

    public function repository(string $repository): Repository
    {
        return await(
            $this->client->repository($repository),
            $this->transport->getLoop()
        );
    }
}
