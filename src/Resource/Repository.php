<?php

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;

final class Repository implements RepositoryInterface
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
    private $lastBuildId;

    /**
     * @var int
     */
    private $lastBuildNumber;

    /**
     * @var string
     */
    private $lastBuildState;

    /**
     * @var int
     */
    private $lastBuildDuration;

    /**
     * @var DateTimeInterface
     */
    private $lastBuildStartedAt;

    /**
     * @var DateTimeInterface
     */
    private $lastBuildFinishedAt;

    /**
     * @var string
     */
    private $githubLanguage;

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
        return $this->lastBuildId;
    }

    public function lastBuildNumber() : int
    {
        return $this->lastBuildNumber;
    }

    public function lastBuildState() : string
    {
        return $this->lastBuildState;
    }

    public function lastBuildDuration() : int
    {
        return $this->lastBuildDuration;
    }

    public function lastBuildStartedAt() : DateTimeInterface
    {
        return $this->lastBuildStartedAt;
    }

    public function lastBuildFinishedAt() : DateTimeInterface
    {
        return $this->lastBuildFinishedAt;
    }

    public function githubLanguage() : string
    {
        return $this->githubLanguage;
    }
}
