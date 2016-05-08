<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;

/**
 * @link https://docs.travis-ci.com/api#builds
 */
interface BuildInterface extends ResourceInterface
{
    public function id() : int;

    public function repositoryId() : int;

    public function commitId() : int;

    public function number() : int;

    public function pullRequest() : bool;

    public function pullRequestTitle() : string;

    public function pullRequestNumber() : int;

    public function config() : array;

    public function state() : string;

    public function startedAt() : DateTimeInterface;

    public function finishedAt() : DateTimeInterface;

    public function duration() : int;

    public function jobIds() : array;
}
