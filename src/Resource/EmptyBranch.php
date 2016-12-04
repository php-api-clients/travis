<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;
use DateTimeInterface;

abstract class EmptyBranch implements BranchInterface, EmptyResourceInterface
{
    /**
     * @return int
     */
    public function id() : int
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

    /**
     * @return int
     */
    public function commitId() : int
    {
        return null;
    }

    /**
     * @return string
     */
    public function number() : string
    {
        return null;
    }

    /**
     * @return array
     */
    public function config() : array
    {
        return null;
    }

    /**
     * @return string
     */
    public function state() : string
    {
        return null;
    }

    /**
     * @return DateTimeInterface
     */
    public function startedAt() : DateTimeInterface
    {
        return null;
    }

    /**
     * @return DateTimeInterface
     */
    public function finishedAt() : DateTimeInterface
    {
        return null;
    }

    /**
     * @return int
     */
    public function duration() : int
    {
        return null;
    }

    /**
     * @return array
     */
    public function jobIds() : array
    {
        return null;
    }

    /**
     * @return bool
     */
    public function pullRequest() : bool
    {
        return null;
    }
}
