<?php

namespace WyriHaximus\Travis;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Builds implements EndpointInterface
{
    use ParentHasClientAwareTrait;

    /**
     * @var Repository
     */
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->setParent($repository);
        $this->repository = $repository;
    }

    public function getRequest(): RequestInterface
    {
        return $this->parent->getClient()->createRequert(
            'GET',
            'repos/' . $this->repository->getRepository() . '/builds'
        );
    }

    public function fromResponse(ResponseInterface $response): EndpointInterface
    {
        $json = json_decode($response->getBody()->getContents());
        $builds = $this->createBuilds($json);
        return new BuildCollection($this->repository, $builds);
    }

    protected function createBuilds($json)
    {
        $builds = [];
        foreach ($json->builds as $build) {
            $builds[] = new Build($this->repository, $build);
        }
        return $builds;
    }

    public function matrix()
    {

    }
}
