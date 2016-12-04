<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use ApiClients\Client\Travis\Resource\Branch as BaseBranch;
use ApiClients\Client\Travis\Resource\BranchInterface;

class Branch extends BaseBranch
{
    public function refresh() : Branch
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (BranchInterface $branch) {
            return $branch->refresh();
        }));
    }
}
