<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotations\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;

/**
 * @EmptyResource("EmptyRepository")
 */
abstract class Repository extends AbstractResource implements RepositoryInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $last_build_id;

    /**
     * @var int
     */
    protected $last_build_number;

    /**
     * @var string
     */
    protected $last_build_state;

    /**
     * @var int
     */
    protected $last_build_duration;

    /**
     * @var int
     */
    protected $last_build_started_at;

    /**
     * @var int
     */
    protected $last_build_finished_at;

    /**
     * @var string
     */
    protected $github_language;

    /**
     * @return int
     */
    public function id() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function slug() : string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function description() : string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function lastBuildId() : int
    {
        return (int)$this->last_build_id;
    }

    /**
     * @return int
     */
    public function lastBuildNumber() : int
    {
        return $this->last_build_number;
    }

    /**
     * @return string
     */
    public function lastBuildState() : string
    {
        return $this->last_build_state;
    }

    /**
     * @return int
     */
    public function lastBuildDuration() : int
    {
        return $this->last_build_duration;
    }

    /**
     * @return int
     */
    public function lastBuildStartedAt() : int
    {
        return $this->last_build_started_at;
    }

    /**
     * @return int
     */
    public function lastBuildFinishedAt() : int
    {
        return $this->last_build_finished_at;
    }

    /**
     * @return string
     */
    public function githubLanguage() : string
    {
        return $this->github_language;
    }
}
