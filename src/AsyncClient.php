<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use WyriHaximus\ApiClient\Transport\Client as Transport;
use WyriHaximus\ApiClient\Transport\Factory;
use function React\Promise\resolve;

class AsyncClient
{
    protected $transport;

    public function __construct(LoopInterface $loop, string $token = '', Transport $transport = null)
    {
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
    }

    public function repository(string $repository): PromiseInterface
    {
        return $this->transport->request('repos/' . $repository)->then(function ($json) {
            return resolve($this->transport->getHydrator()->hydrate('Repository', $json['repo']));
        });
    }
}
