<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use ApiClients\Client\Travis\Resource\Broadcast as BaseBroadcast;
use ApiClients\Client\Travis\Resource\BroadcastInterface;

class Broadcast extends BaseBroadcast
{
    public function refresh() : Broadcast
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (BroadcastInterface $broadcast) {
            return $broadcast->refresh();
        }));
    }
}
