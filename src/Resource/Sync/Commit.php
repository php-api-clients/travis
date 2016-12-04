<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use ApiClients\Client\Travis\Resource\Commit as BaseCommit;
use ApiClients\Client\Travis\Resource\CommitInterface;

class Commit extends BaseCommit
{
    public function refresh() : Commit
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (CommitInterface $commit) {
            return $commit->refresh();
        }));
    }
}
