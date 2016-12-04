<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface RepositoryInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Repository';

    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return string
     */
    public function slug() : string;

    /**
     * @return string
     */
    public function description() : string;

    /**
     * @return int
     */
    public function lastBuildId() : int;

    /**
     * @return int
     */
    public function lastBuildNumber() : int;

    /**
     * @return string
     */
    public function lastBuildState() : string;

    /**
     * @return int
     */
    public function lastBuildDuration() : int;

    /**
     * @return int
     */
    public function lastBuildStartedAt() : int;

    /**
     * @return int
     */
    public function lastBuildFinishedAt() : int;

    /**
     * @return string
     */
    public function githubLanguage() : string;
}
