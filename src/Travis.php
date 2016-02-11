<?php

namespace WyriHaximus\Travis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Travis implements EndpointInterface
{
    use ClientAwareTrait;

    /**
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
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
