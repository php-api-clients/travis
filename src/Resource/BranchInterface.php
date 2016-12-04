<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;
use DateTimeInterface;

interface BranchInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Branch';

    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return int
     */
    public function repositoryId() : int;

    /**
     * @return int
     */
    public function commitId() : int;

    /**
     * @return string
     */
    public function number() : string;

    /**
     * @return array
     */
    public function config() : array;

    /**
     * @return string
     */
    public function state() : string;

    /**
     * @return DateTimeInterface
     */
    public function startedAt() : DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    public function finishedAt() : DateTimeInterface;

    /**
     * @return int
     */
    public function duration() : int;

    /**
     * @return array
     */
    public function jobIds() : array;

    /**
     * @return bool
     */
    public function pullRequest() : bool;
}
