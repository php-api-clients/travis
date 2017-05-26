<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;
use DateTimeInterface;

interface CommitInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Commit';

    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return string
     */
    public function sha(): string;

    /**
     * @return string
     */
    public function branch(): string;

    /**
     * @return string
     */
    public function message(): string;

    /**
     * @return DateTimeInterface
     */
    public function comittedAt(): DateTimeInterface;

    /**
     * @return string
     */
    public function authorName(): string;

    /**
     * @return string
     */
    public function authorEmail(): string;

    /**
     * @return string
     */
    public function committerName(): string;

    /**
     * @return string
     */
    public function committerEmail(): string;

    /**
     * @return string
     */
    public function compareUrl(): string;
}
