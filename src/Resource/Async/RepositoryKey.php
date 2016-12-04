<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\Resource\RepositoryKey as BaseRepositoryKey;

class RepositoryKey extends BaseRepositoryKey
{
    public function refresh() : RepositoryKey
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
