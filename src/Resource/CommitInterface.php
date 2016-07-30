<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;
use ApiClients\Foundation\Resource\ResourceInterface;

interface CommitInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return string
     */
    public function sha() : string;

    /**
     * @return string
     */
    public function branch() : string;

    /**
     * @return string
     */
    public function message() : string;

    /**
     * @return DateTimeInterface
     */
    public function committedAt() : DateTimeInterface;

    /**
     * @return string
     */
    public function authorName() : string;

    /**
     * @return string
     */
    public function authorEmail() : string;

    /**
     * @return string
     */
    public function committerName() : string;

    /**
     * @return string
     */
    public function committerEmail() : string;

    /**
     * @return string
     */
    public function compareUrl() : string;
}
