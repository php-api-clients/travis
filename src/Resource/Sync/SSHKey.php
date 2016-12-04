<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\SSHKey as BaseSSHKey;
use WyriHaximus\Travis\Resource\SSHKeyInterface;

class SSHKey extends BaseSSHKey
{
    public function refresh() : SSHKey
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (SSHKeyInterface $sSHKey) {
            return $sSHKey->refresh();
        }));
    }
}
