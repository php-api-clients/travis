<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\Hook as BaseHook;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;

class Hook extends BaseHook
{
    public function refresh(): Hook
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (HookInterface $hook) {
            return $hook->refresh();
        }));
    }
}
