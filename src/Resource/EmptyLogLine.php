<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptyLogLine implements LogLineInterface, EmptyResourceInterface
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
    public function log() : string
    {
        return null;
    }

    /**
     * @return int
     */
    public function number() : int
    {
        return null;
    }

    /**
     * @return bool
     */
    public function final() : bool
    {
        return null;
    }
}
