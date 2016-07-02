<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Job as BaseJob;

class Job extends BaseJob
{
    public function annotations(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('annotations')->toArray()));
    }
}
