<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\Resource\Commit as BaseCommit;
use Exception;
use React\Promise\PromiseInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\reject;

class Commit extends BaseCommit
{
    public function refresh() : PromiseInterface
    {
        return reject(new Exception('Can\'t refresh as there is no reference to the relative repository'));
    }
}
