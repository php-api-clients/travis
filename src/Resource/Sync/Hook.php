<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\Hook as BaseHook;
use WyriHaximus\Travis\Resource\HookInterface;

class Hook extends BaseHook
{
    public function refresh() : Hook
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (HookInterface $hook) {
            return $hook->refresh();
        }));
    }
}
