<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\User as BaseUser;
use WyriHaximus\Travis\Resource\UserInterface;

class User extends BaseUser
{
    /**
     * @return User
     */
    public function sync() : User
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (UserInterface $user) {
                return $user->sync();
            })
        );
    }

    /**
     * @return User
     */
    public function refresh() : User
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (UserInterface $user) {
                return $user->refresh();
            })
        );
    }
}
