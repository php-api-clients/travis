<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;
use DateTimeInterface;

abstract class EmptyCache implements CacheInterface, EmptyResourceInterface
{
    /**
     * @return int
     */
    public function repositoryId() : int
    {
        return null;
    }

    /**
     * @return int
     */
    public function size() : int
    {
        return null;
    }

    /**
     * @return string
     */
    public function slug() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function branch() : string
    {
        return null;
    }

    /**
     * @return DateTimeInterface
     */
    public function lastModified() : DateTimeInterface
    {
        return null;
    }
}
