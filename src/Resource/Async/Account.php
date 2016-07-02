<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use WyriHaximus\Travis\Resource\Account as BaseAccount;

class Account extends BaseAccount
{
    public function refresh() : Account
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
