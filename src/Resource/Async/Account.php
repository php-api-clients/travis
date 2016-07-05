<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Account as BaseAccount;

class Account extends BaseAccount
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
