<?php

namespace WyriHaximus\Travis;

trait ClientAwareTrait
{
    /**
     * @var HttpClient
     */
    protected $client;

    protected function setClient(HttpClient $client)
    {
        $this->client = $client;
    }

    public function getClient(): HttpClient
    {
        return $this->client;
    }
}
