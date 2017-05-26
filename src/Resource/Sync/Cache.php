<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\Cache as BaseCache;
use ApiClients\Client\Travis\Resource\CacheInterface;
use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;

class Cache extends BaseCache
{
    public function refresh(): Cache
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (CacheInterface $cache) {
            return $cache->refresh();
        }));
    }
}
