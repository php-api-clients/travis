<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptyEnvironmentVariable implements EnvironmentVariableInterface, EmptyResourceInterface
{
    /**
     * @return string
     */
    public function id() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function value() : string
    {
        return null;
    }

    /**
     * @return bool
     */
    public function public() : bool
    {
        return null;
    }

    /**
     * @return int
     */
    public function repositoryId() : int
    {
        return null;
    }
}
