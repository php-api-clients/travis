<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptyRepository implements RepositoryInterface, EmptyResourceInterface
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
    public function slug(): string
    {
        return null;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return null;
    }

    /**
     * @return int
     */
    public function lastBuildId(): int
    {
        return null;
    }

    /**
     * @return int
     */
    public function lastBuildNumber(): int
    {
        return null;
    }

    /**
     * @return int
     */
    public function lastBuildState(): string
    {
        return null;
    }

    /**
     * @return int
     */
    public function lastBuildDuration(): int
    {
        return null;
    }

    /**
     * @return int
     */
    public function lastBuildStartedAt(): int
    {
        return null;
    }

    /**
     * @return int
     */
    public function lastBuildFinishedAt(): int
    {
        return null;
    }

    /**
     * @return string
     */
    public function githubLanguage(): string
    {
        return null;
    }
}
