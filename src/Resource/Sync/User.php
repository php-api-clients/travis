<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\User as BaseUser;

class User extends BaseUser
{
    /**
     * @return User
     */
    public function sync() : User
    {
        return $this->wait($this->callAsync('sync'));
    }

    /**
     * @return User
     */
    public function refresh() : User
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
