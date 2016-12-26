<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\HooksCommand;
use ApiClients\Client\Travis\Resource\Hook as BaseHook;
use ApiClients\Client\Travis\Resource\HookInterface;
use React\Promise\PromiseInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\reject;
use function React\Promise\resolve;

class Hook extends BaseHook
{
    public function refresh() : PromiseInterface
    {
        return Promise::fromObservable(unwrapObservableFromPromise($this->handleCommand(
            new HooksCommand()
        ))->filter(function (HookInterface $hook) {
            return $this->id() === $hook->id();
        }));
    }
}
