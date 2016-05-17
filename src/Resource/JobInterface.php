<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;

/**
 * @link https://docs.travis-ci.com/api#jobs
 */
interface JobInterface extends ResourceInterface
{
    public function id() : int;

    public function buildId() : int;

    public function repositoryId() : int;

    public function commitId() : int;

    public function logId() : int;

    public function number() : string;

    public function config() : array;

    public function state() : string;

    public function startedAt() : DateTimeInterface;

    public function finishedAt() : DateTimeInterface;

    public function queue() : string;

    public function allowFailure() : bool;

    public function annotationIds() : array;
}
