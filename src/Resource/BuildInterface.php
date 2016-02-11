<?php

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;

/**
 * @link https://docs.travis-ci.com/api#builds
 */
interface BuildInterface
{
    public function id() : int;

    public function repositoryId() : int;

    public function commitId() : int;

    public function number() : string;

    public function pullRequest() : bool;

    public function pullRequestTitle() : string;

    public function pullRequestNumber() : string;

    public function config() : array;

    public function state() : string;

    public function startedAt() : DateTimeInterface;

    public function finishedAt() : DateTimeInterface;

    public function duration() : int;

    public function jobIds() : array;
}
