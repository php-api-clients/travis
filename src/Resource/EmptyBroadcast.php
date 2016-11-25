<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptyBroadcast implements BroadcastInterface, EmptyResourceInterface
{
    /**
     * @return int
     */
    public function id() : int
    {
        return null;
    }

    /**
     * @return string
     */
    public function message() : string
    {
        return null;
    }
}
