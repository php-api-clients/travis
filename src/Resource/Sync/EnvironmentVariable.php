<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\EnvironmentVariable as BaseEnvironmentVariable;

class EnvironmentVariable extends BaseEnvironmentVariable
{
    /**
     * @return EnvironmentVariable
     */
    public function refresh(): EnvironmentVariable
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
