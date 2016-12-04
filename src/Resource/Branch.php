<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotations\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;
use DateTimeInterface;

/**
 * @EmptyResource("EmptyBranch")
 */
abstract class Branch extends AbstractResource implements BranchInterface
{
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
     * @var array
     */
    protected $config;

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
     * @var array
     */
    protected $job_ids;

    /**
     * @var bool
     */
    protected $pull_request;

    /**
     * @return int
     */
    public function id() : int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function repositoryId() : int
    {
        return $this->repository_id;
    }

    /**
     * @return int
     */
    public function commitId() : int
    {
        return $this->commit_id;
    }

    /**
     * @return string
     */
    public function number() : string
    {
        return $this->number;
    }

    /**
     * @return array
     */
    public function config() : array
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function state() : string
    {
        return $this->state;
    }

    /**
     * @return DateTimeInterface
     */
    public function startedAt() : DateTimeInterface
    {
        return $this->started_at;
    }

    /**
     * @return DateTimeInterface
     */
    public function finishedAt() : DateTimeInterface
    {
        return $this->finished_at;
    }

    /**
     * @return int
     */
    public function duration() : int
    {
        return $this->duration;
    }

    /**
     * @return array
     */
    public function jobIds() : array
    {
        return $this->job_ids;
    }

    /**
     * @return bool
     */
    public function pullRequest() : bool
    {
        return $this->pull_request;
    }
}
