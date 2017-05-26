<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;
use DateTimeInterface;

abstract class EmptyUser implements UserInterface, EmptyResourceInterface
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
    public function login(): string
    {
        return null;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return null;
    }

    /**
     * @return string
     */
    public function gravatarId(): string
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isSyncing(): bool
    {
        return null;
    }

    /**
     * @return DateTimeInterface
     */
    public function syncedAt(): DateTimeInterface
    {
        return null;
    }

    /**
     * @return bool
     */
    public function correctScopes(): bool
    {
        return null;
    }

    /**
     * @return DateTimeInterface
     */
    public function createdAt(): DateTimeInterface
    {
        return null;
    }
}
