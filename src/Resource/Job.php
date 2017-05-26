<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotation\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;
use DateTimeInterface;

/**
 * @EmptyResource("EmptyJob")
 */
abstract class Job extends AbstractResource implements JobInterface
{
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
     * @var string
     */
    protected $queue;

    /**
     * @var bool
     */
    protected $allow_failure;

    /**
     * @var array
     */
    protected $annotation_ids;

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function buildId(): int
    {
        return $this->build_id;
    }

    /**
     * @return int
     */
    public function repositoryId(): int
    {
        return $this->repository_id;
    }

    /**
     * @return int
     */
    public function commitId(): int
    {
        return $this->commit_id;
    }

    /**
     * @return int
     */
    public function logId(): int
    {
        return $this->log_id;
    }

    /**
     * @return string
     */
    public function number(): string
    {
        return $this->number;
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function state(): string
    {
        return $this->state;
    }

    /**
     * @return DateTimeInterface
     */
    public function startedAt(): DateTimeInterface
    {
        return $this->started_at;
    }

    /**
     * @return DateTimeInterface
     */
    public function finishedAt(): DateTimeInterface
    {
        return $this->finished_at;
    }

    /**
     * @return string
     */
    public function queue(): string
    {
        return $this->queue;
    }

    /**
     * @return bool
     */
    public function allowFailure(): bool
    {
        return $this->allow_failure;
    }

    /**
     * @return array
     */
    public function annotationIds(): array
    {
        return $this->annotation_ids;
    }
}
