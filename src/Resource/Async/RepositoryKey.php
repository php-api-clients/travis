<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\Resource\RepositoryKey as BaseRepositoryKey;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

class RepositoryKey extends BaseRepositoryKey
{
    public function refresh() : PromiseInterface
    {
        return resolve($this);
    }
}
