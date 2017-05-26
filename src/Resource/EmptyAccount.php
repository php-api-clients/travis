<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptyAccount implements AccountInterface, EmptyResourceInterface
{
    /**
     * @return int
     */
    public function id(): int
    {
        return null;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return null;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return null;
    }

    /**
     * @return string
     */
    public function login(): string
    {
        return null;
    }

    /**
     * @return int
     */
    public function reposCount(): int
    {
        return null;
    }
}
