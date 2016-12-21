<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\CachesCommand;
use ApiClients\Client\Travis\Resource\Cache as BaseCache;
use ApiClients\Client\Travis\Resource\CacheInterface;
use React\Promise\PromiseInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\reject;
use function React\Promise\resolve;

class Cache extends BaseCache
{
    public function refresh() : PromiseInterface
    {
        return Promise::fromObservable(unwrapObservableFromPromise($this->handleCommand(
            new CachesCommand($this->repositoryId())
        ))->filter(function (CacheInterface $cache) {
            return $this->slug() === $cache->slug();
        }));
    }
}
