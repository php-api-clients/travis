<?php

namespace WyriHaximus\Travis;

use ArrayIterator;
use IteratorAggregate;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class JobCollection implements EndpointInterface, IteratorAggregate
{
    use ParentHasClientAwareTrait;

    /**
     * @var Repository
     */
    protected $build;

    /**
     * @var array
     */
    protected $builds;

    public function __construct(Build $build, array $builds)
    {
        $this->setParent($build);
        $this->build = $build;
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

    /**
     * @return Repository
     */
    public function getBuild()
    {
        return $this->build;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->builds);
    }
}
