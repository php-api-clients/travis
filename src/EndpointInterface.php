<?php

namespace WyriHaximus\Travis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface EndpointInterface
{
    public function getClient(): HttpClient;

    public function getRequest(): RequestInterface;

    public function fromResponse(ResponseInterface $response): EndpointInterface;
}
