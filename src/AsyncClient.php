<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\EventLoop\LoopInterface;
use Rx\Observable;
use Rx\React\Promise;
use ApiClients\Foundation\Transport\Client as Transport;
use ApiClients\Foundation\Transport\Factory;
use ApiClients\Pusher\AsyncClient as PusherAsyncClient;

class AsyncClient
{
    protected $transport;

    public function __construct(LoopInterface $loop, Transport $transport = null)
    {
        if (!($transport instanceof Transport)) {
            $pusher = new PusherAsyncClient($loop, ApiSettings::PUSHER_KEY);
            $transport = Factory::create($loop, [
                'resource_namespace' => 'Async',
                'setters' => [
                    'setPusher' => $pusher,
                ],
            ] + ApiSettings::TRANSPORT_OPTIONS);
        }
        $this->transport = $transport;
    }

    public function repository(string $repository): Observable
    {
        return Promise::toObservable($this->transport->request('repos/' . $repository))
            ->map(function ($json) {
                return $this->transport->getHydrator()->hydrate('Repository', $json['repo']);
            });
    }
}
