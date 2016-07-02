<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\EventLoop\Factory as LoopFactory;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\RepositoryInterface;
use WyriHaximus\Travis\Resource\Sync\Repository;
use WyriHaximus\ApiClient\Transport\Client as Transport;
use WyriHaximus\ApiClient\Transport\Factory;
use function Clue\React\Block\await;
use function React\Promise\resolve;

class Client
{
    protected $transport;
    protected $client;

    public function __construct(string $token = '', Transport $transport = null)
    {
        $loop = LoopFactory::create();
        if (!($transport instanceof Transport)) {
            $options = [
                    'resource_namespace' => 'Async',
                ] + ApiSettings::TRANSPORT_OPTIONS;

            if ($token !== '') {
                $options['headers']['Authorization'] = 'token ' . $token;
            }

            $transport = Factory::create($loop, $options);
        }
        $this->transport = $transport;
        $this->client = new AsyncClient($loop, $token, $this->transport);
    }

    public function repository(string $repository): RepositoryInterface
    {
        return await(
            $this->client->repository($repository),
            $this->transport->getLoop()
        );
    }

    public function hooks(): array
    {
        return await(
            Promise::fromObservable(
                $this->client->hooks()->toArray()
            ),
            $this->transport->getLoop()
        );
    }
}
