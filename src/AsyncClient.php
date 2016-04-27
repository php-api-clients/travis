<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Async\Repository;
use WyriHaximus\Travis\Transport\Client as Transport;
use WyriHaximus\Travis\Transport\Factory;
use function React\Promise\resolve;

class AsyncClient
{
    protected $transport;

    public function __construct(Transport $transport = null)
    {
        if (!($transport instanceof Transport)) {
            $transport = Factory::create();
        }
        $this->transport = $transport;
    }

    public function repository(string $repository): PromiseInterface
    {
        return $this->transport->request('repos/' . $repository)->then(function ($json) {
            return resolve($this->transport->hydrate(Repository::class, $json['repo']));
        });
    }
}
