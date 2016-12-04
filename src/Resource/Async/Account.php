<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
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
        return $this->handleCommand(new SimpleRequestCommand('accounts'))->then(function ($json) {
            foreach ($json['accounts'] as $account) {
                if ($account['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->handleCommand(new HydrateCommand('Account', $account)));
            }

            return reject();
        });
    }
}
