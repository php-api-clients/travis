<?php

namespace WyriHaximus\Travis;

class BuildMatrix
{
    use ClientAwareTrait;

    /**
     * @var string
     */
    protected $repository;

    public function __construct(Client $client)
    {
        $this->setClient($client);
        $this->repository = $repository;
    }

    public function matrix()
    {

    }
}
