<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\SSHKey as BaseSSHKey;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;

class SSHKey extends BaseSSHKey
{
    public function refresh(): SSHKey
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (SSHKeyInterface $sSHKey) {
            return $sSHKey->refresh();
        }));
    }
}
