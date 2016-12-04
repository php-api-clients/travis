<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Cache as BaseCache;
use function React\Promise\reject;
use function React\Promise\resolve;

class Cache extends BaseCache
{
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('repos/' . $this->repositoryId() . '/caches')
        )->then(function ($json) {
            foreach ($json['caches'] as $cache) {
                if ($cache['slug'] != $this->slug()) {
                    continue;
                }

                return resolve($this->handleCommand(new HydrateCommand('Cache', $cache)));
            }

            return reject();
        });
    }
}
