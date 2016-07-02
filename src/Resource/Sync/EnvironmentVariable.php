<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\EnvironmentVariable as BaseEnvironmentVariable;

class EnvironmentVariable extends BaseEnvironmentVariable
{
    public function refresh() : EnvironmentVariable
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
