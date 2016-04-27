<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\Travis\Transport\Client;

trait TransportAwareTrait
{
    private $transport;

    public function setTransport(Client $transport)
    {
        $this->transport = $transport;
    }

    protected function getTransport(): Client
    {
        return $this->transport;
    }
}
