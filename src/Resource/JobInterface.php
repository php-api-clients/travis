<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;
use DateTimeInterface;

interface JobInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Job';

    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return int
     */
    public function buildId() : int;

    /**
     * @return int
     */
    public function repositoryId() : int;

    /**
     * @return int
     */
    public function commitId() : int;

    /**
     * @return int
     */
    public function logId() : int;

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
     * @return string
     */
    public function queue() : string;

    /**
     * @return bool
     */
    public function allowFailure() : bool;

    /**
     * @return array
     */
    public function annotationIds() : array;
}
