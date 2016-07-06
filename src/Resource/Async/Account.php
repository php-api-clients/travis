<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Account as BaseAccount;
use function React\Promise\reject;
use function React\Promise\resolve;

class Account extends BaseAccount
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->getTransport()->request('accounts')->then(function ($json) {
            foreach ($json['accounts'] as $account) {
                if ($account['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->getTransport()->getHydrator()->hydrate('Account', $account));
            }

            return reject();
        });
    }
}
