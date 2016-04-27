<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;

class Repository implements RepositoryInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $last_build_id;

    /**
     * @var int
     */
    private $last_build_number;

    /**
     * @var string
     */
    private $last_build_state;

    /**
     * @var int
     */
    private $last_build_duration;

    /**
     * @var DateTimeInterface
     */
    private $last_build_started_at;

    /**
     * @var DateTimeInterface
     */
    private $last_build_finished_at;

    /**
     * @var string
     */
    private $github_language;

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
}
