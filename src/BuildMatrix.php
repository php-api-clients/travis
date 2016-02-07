<?php

namespace WyriHaximus\Travis;

use Iterator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use React\Promise\CancellablePromiseInterface;
use React\Promise\ExtendedPromiseInterface;

class BuildMatrix implements Iterator, ExtendedPromiseInterface, CancellablePromiseInterface, EndpointInterface
{
    use IteratorTrait;
    use LazyPromiseTrait;
    use ParentHasClientAwareTrait;

    /**
     * @var Build
     */
    protected $build;

    public function __construct(Build $build)
    {
        $this->setFactory(function () {
            return $this->getClient()->requestAsync($this);
        });
        $this->setParent($build);
        $this->build = $build;
    }

    public function getRequest(): RequestInterface
    {
        return $this->parent->getClient()->createRequest(
            'GET',
            'builds/' . $this->build->getId()
        );
    }

    public function fromResponse(ResponseInterface $response): EndpointInterface
    {
        $json = json_decode($response->getBody()->getContents());
        $jobs = $this->createJobs($json);
        return new JobCollection($this->build, $jobs);
    }

    protected function createJobs($json)
    {
        $builds = [];
        foreach ($json->jobs as $build) {
            $builds[] = new Job($this->build, $build);
        }
        return $builds;
    }

    public function matrix()
    {

    }
}
