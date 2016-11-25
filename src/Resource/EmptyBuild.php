<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;
use DateTimeInterface;

abstract class EmptyBuild implements BuildInterface, EmptyResourceInterface
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
     * @return bool
     */
    public function pullRequest() : bool
    {
        return null;
    }

    /**
     * @return string
     */
    public function pullRequestTitle() : string
    {
        return null;
    }

    /**
     * @return int
     */
    public function pullRequestNumber() : int
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
}
