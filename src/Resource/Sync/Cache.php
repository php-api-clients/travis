<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\Cache as BaseCache;
use WyriHaximus\Travis\Resource\CacheInterface;

class Cache extends BaseCache
{
    public function refresh() : Cache
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (CacheInterface $cache) {
            return $cache->refresh();
        }));
    }
}
