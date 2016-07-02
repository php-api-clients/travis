<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\TransportAwareTrait;

abstract class Broadcast implements BroadcastInterface
{
    use TransportAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $message;

    /**
     * @return int
     */
    public function id() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function message() : string
    {
        return $this->message;
    }
}
