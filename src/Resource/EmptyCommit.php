<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;
use DateTimeInterface;

abstract class EmptyCommit implements CommitInterface, EmptyResourceInterface
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
    public function sha() : string
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
     * @return string
     */
    public function message() : string
    {
        return null;
    }

    /**
     * @return DateTimeInterface
     */
    public function comittedAt() : DateTimeInterface
    {
        return null;
    }

    /**
     * @return string
     */
    public function authorName() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function authorEmail() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function committerName() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function committerEmail() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function compareUrl() : string
    {
        return null;
    }
}
