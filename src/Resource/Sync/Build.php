<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\ApiClient\Resource\CallAsyncTrait;
use WyriHaximus\Travis\Resource\Build as BaseBuild;
use function Clue\React\Block\await;

class Build extends BaseBuild
{
    use CallAsyncTrait;

    public function jobs(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('jobs')->toArray()));
    }

    public function job(int $id): Job
    {
        return $this->wait($this->callAsync('job', $id));
    }
}
