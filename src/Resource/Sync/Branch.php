<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\Branch as BaseBranch;
use WyriHaximus\Travis\Resource\BranchInterface;

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
