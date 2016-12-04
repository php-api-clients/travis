<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\RepositoryKey as BaseRepositoryKey;
use WyriHaximus\Travis\Resource\RepositoryKeyInterface;

class RepositoryKey extends BaseRepositoryKey
{
    public function refresh() : RepositoryKey
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (RepositoryKeyInterface $repositoryKey) {
            return $repositoryKey->refresh();
        }));
    }
}
