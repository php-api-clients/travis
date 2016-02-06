<?php

namespace WyriHaximus\Travis;

use ArrayIterator;
use IteratorAggregate;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BuildCollection implements EndpointInterface, IteratorAggregate
{
    use ParentHasClientAwareTrait;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $builds;

    public function __construct(Repository $repository, array $builds)
    {
        $this->setParent($repository);
        $this->repository = $repository;
        $this->builds = $builds;
    }

    public function getRequest(): RequestInterface
    {
        // TODO: Implement getRequest() method.
    }

    public function fromResponse(ResponseInterface $response): EndpointInterface
    {
        // TODO: Implement fromResponse() method.
    }

    public function getIterator()
    {
        return new ArrayIterator($this->builds);
    }
}
