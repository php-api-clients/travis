<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\Account as BaseAccount;
use WyriHaximus\Travis\Resource\AccountInterface;

class Account extends BaseAccount
{
    public function refresh() : Account
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (AccountInterface $account) {
            return $account->refresh();
        }));
    }
}
