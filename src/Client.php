<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\EventLoop\Factory as LoopFactory;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Sync\Repository;
use ApiClients\Foundation\Transport\Client as Transport;
use ApiClients\Foundation\Transport\Factory;
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
            ] + ApiSettings::TRANSPORT_OPTIONS);
        }
        $this->transport = $transport;
        $this->client = new AsyncClient($loop, $this->transport);
    }

    public function repository(string $repository): Repository
    {
        return await(
            Promise::fromObservable($this->client->repository($repository)),
            $this->transport->getLoop()
        );
    }
}
