<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;
use WyriHaximus\ApiClient\Resource\TransportAwareTrait;

abstract class Repository implements RepositoryInterface
{
    use TransportAwareTrait;

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
     * @var DateTimeInterface
     */
    protected $last_build_started_at;

    /**
     * @var DateTimeInterface
     */
    protected $last_build_finished_at;

    /**
     * @var string
     */
    protected $github_language;

    public function id() : int
    {
        return $this->id;
    }

    public function slug() : string
    {
        return $this->slug;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function lastBuildId() : int
    {
        return $this->last_build_id;
    }

    public function lastBuildNumber() : int
    {
        return $this->last_build_number;
    }

    public function lastBuildState() : string
    {
        return $this->last_build_state;
    }

    public function lastBuildDuration() : int
    {
        return $this->last_build_duration;
    }

    public function lastBuildStartedAt() : DateTimeInterface
    {
        return $this->last_build_started_at;
    }

    public function lastBuildFinishedAt() : DateTimeInterface
    {
        return $this->last_build_finished_at;
    }

    public function githubLanguage() : string
    {
        return $this->github_language;
    }

    public function refresh()
    {
        // TODO
    }
}
