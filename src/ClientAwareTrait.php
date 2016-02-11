<?php

namespace WyriHaximus\Travis;

trait ClientAwareTrait
{
    /**
     * @var Client
     */
    protected $client;

    protected function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
