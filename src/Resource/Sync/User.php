<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\User as BaseUser;

class User extends BaseUser
{
    public function sync() : User
    {
        return $this->wait($this->callAsync('sync'));
    }

    public function refresh() : User
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
