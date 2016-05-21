<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;
use WyriHaximus\ApiClient\Resource\TransportAwareTrait;

abstract class Build implements BuildInterface
{
    use TransportAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $repository_id;

    /**
     * @var int
     */
    protected $commit_id;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var bool
     */
    protected $pull_request;

    /**
     * @var string
     */
    protected $pull_request_title;

    /**
     * @var int
     */
    protected $pull_request_number;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $state;

    /**
     * @var DateTimeInterface
     */
    protected $started_at;

    /**
     * @var DateTimeInterface
     */
    protected $finished_at;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var int[]
     */
    protected $job_ids = [];

    public function id() : int
    {
        return $this->id;
    }

    public function repositoryId() : int
    {
        return $this->repository_id;
    }

    public function commitId() : int
    {
        return $this->commit_id;
    }

    public function number() : int
    {
        return $this->number;
    }

    public function pullRequest() : bool
    {
        return $this->pull_request;
    }

    public function pullRequestTitle() : string
    {
        return $this->pull_request_title;
    }

    public function pullRequestNumber() : int
    {
        return $this->pull_request_number;
    }

    public function config() : array
    {
        return $this->config;
    }

    public function state() : string
    {
        return $this->state;
    }

    public function startedAt() : DateTimeInterface
    {
        return $this->started_at;
    }

    public function finishedAt() : DateTimeInterface
    {
        return $this->finished_at;
    }

    public function duration() : int
    {
        return $this->duration;
    }

    public function jobIds() : array
    {
        return $this->job_ids;
    }

    public function refresh()
    {
        // TODO
    }
}
