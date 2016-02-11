<?php

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
    private $repositoryId;

    /**
     * @var int
     */
    private $commitId;

    /**
     * @var string
     */
    private $number;

    /**
     * @var bool
     */
    private $pullRequest;

    /**
     * @var string
     */
    private $pullRequestTitle;

    /**
     * @var string
     */
    private $pullRequestNumber;

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
    private $startedAt;

    /**
     * @var DateTimeInterface
     */
    private $finishedAt;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var int[]
     */
    private $jobIds = [];

    public function id() : int
    {
        return $this->id;
    }

    public function repositoryId() : int
    {
        return $this->repositoryId;
    }

    public function commitId() : int
    {
        return $this->commitId;
    }

    public function number() : string
    {
        return $this->number;
    }

    public function pullRequest() : bool
    {
        return $this->pullRequest;
    }

    public function pullRequestTitle() : string
    {
        return $this->pullRequestTitle;
    }

    public function pullRequestNumber() : string
    {
        return $this->pullRequestNumber;
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
        return $this->startedAt;
    }

    public function finishedAt() : DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function duration() : int
    {
        return $this->duration;
    }

    public function jobIds() : array
    {
        return $this->jobIds;
    }
}
