<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;
use DateTimeInterface;

abstract class EmptyJob implements JobInterface, EmptyResourceInterface
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
    public function buildId() : int
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
     * @return int
     */
    public function logId() : int
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
     * @return string
     */
    public function queue() : string
    {
        return null;
    }

    /**
     * @return bool
     */
    public function allowFailure() : bool
    {
        return null;
    }

    /**
     * @return array
     */
    public function annotationIds() : array
    {
        return null;
    }
}
