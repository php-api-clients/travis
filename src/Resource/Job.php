<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;
use ApiClients\Foundation\Resource\TransportAwareTrait;
use ApiClients\Pusher\PusherAwareTrait;

class Job implements JobInterface
{
    use TransportAwareTrait;
    use PusherAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $build_id;

    /**
     * @var int
     */
    protected $repository_id;

    /**
     * @var int
     */
    protected $commit_id;

    /**
     * @var int
     */
    protected $log_id;

    /**
     * @var string
     */
    protected $number;

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
     * @var string
     */
    protected $queue;

    /**
     * @var bool
     */
    protected $allow_failure;

    /**
     * @var int[]
     */
    protected $annotation_ids;

    public function id() : int
    {
        return $this->id;
    }

    public function buildId() : int
    {
        return $this->build_id;
    }

    public function repositoryId() : int
    {
        return $this->repository_id;
    }

    public function commitId() : int
    {
        return $this->commit_id;
    }

    public function logId() : int
    {
        return $this->log_id;
    }

    public function number() : string
    {
        return $this->number;
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

    public function queue() : string
    {
        return $this->queue;
    }

    public function allowFailure() : bool
    {
        return $this->allow_failure;
    }

    public function annotationIds() : array
    {
        return $this->annotation_ids;
    }

    public function annotations()
    {
        throw new AbstractMethodException();
    }

    public function refresh()
    {
        throw new AbstractMethodException();
    }
}
