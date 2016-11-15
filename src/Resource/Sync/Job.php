<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\ApiClient\Resource\CallAsyncTrait;
use WyriHaximus\Travis\Resource\Job as BaseJob;

class Job extends BaseJob
{
    use CallAsyncTrait;

    /**
     * @return array
     */
    public function annotations(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('annotations')->toArray()));
    }

    /**
     * @return Job
     */
    public function refresh(): Job
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
