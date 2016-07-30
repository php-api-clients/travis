<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;
use ApiClients\Foundation\Resource\ResourceInterface;

/**
 * @link https://docs.travis-ci.com/api#repositories
 */
interface RepositoryInterface extends ResourceInterface
{
    public function id() : int;

    public function slug() : string;

    public function description() : string;

    public function lastBuildId() : int;

    public function lastBuildNumber() : string;

    public function lastBuildState() : string;

    public function lastBuildDuration() : int;

    public function lastBuildStartedAt() : DateTimeInterface;

    public function lastBuildFinishedAt() : DateTimeInterface;

    public function githubLanguage() : string;
}
