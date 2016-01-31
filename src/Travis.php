<?php

namespace WyriHaximus\Travis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Travis implements EndpointInterface
{
    use ClientAwareTrait;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    public function repository(string $repository): Repository
    {
        return new Repository($this, $repository);
    }

    public function getRequest(): RequestInterface
    {
        // TODO: Implement getRequest() method.
    }

    public function fromResponse(ResponseInterface $response): EndpointInterface
    {
        // TODO: Implement fromResponse() method.
    }
}
