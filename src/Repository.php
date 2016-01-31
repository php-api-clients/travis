<?php

namespace WyriHaximus\Travis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Repository implements EndpointInterface
{
    use ParentHasClientAwareTrait;

    /**
     * @var string
     */
    protected $repository;

    public function __construct(Travis $parent, string $repository)
    {
        $this->setParent($parent);
        $this->repository = $repository;
    }

    public function getRepository(): string
    {
        return $this->repository;
    }

    public function builds(): Builds
    {
        return new Builds($this);
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
