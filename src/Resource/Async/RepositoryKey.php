<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\Resource\RepositoryKey as BaseRepositoryKey;
use Exception;
use React\Promise\PromiseInterface;
use function React\Promise\reject;

class RepositoryKey extends BaseRepositoryKey
{
    public function refresh(): PromiseInterface
    {
        return reject(new Exception('Can\'t refresh as there is no reference to the relative repository'));
    }
}
