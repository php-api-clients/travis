<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\AccountsCommand;
use ApiClients\Client\Travis\Resource\Account as BaseAccount;
use ApiClients\Client\Travis\Resource\AccountInterface;
use React\Promise\PromiseInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;

class Account extends BaseAccount
{
    /**
     * @return PromiseInterface
     */
    public function refresh(): PromiseInterface
    {
        return Promise::fromObservable(unwrapObservableFromPromise($this->handleCommand(
            new AccountsCommand()
        ))->filter(function (AccountInterface $account) {
            return $this->id() === $account->id();
        }));
    }
}
