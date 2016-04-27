<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;

final class Build implements BuildInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $repository_id;

    /**
     * @var int
     */
    private $commit_id;

    /**
     * @var string
     */
    private $number;

    /**
     * @var bool
     */
    private $pull_request;

    /**
     * @var string
     */
    private $pull_request_title;

    /**
     * @var string
     */
    private $pull_request_number;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var string
     */
    private $state;

    /**
     * @var DateTimeInterface
     */
    private $started_at;

    /**
     * @var DateTimeInterface
     */
    private $finished_at;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var int[]
     */
    private $job_ids = [];

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

    public function number() : string
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

    public function pullRequestNumber() : string
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
}
