<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\VarsCommand;
use ApiClients\Client\Travis\Resource\EnvironmentVariable as BaseEnvironmentVariable;
use ApiClients\Client\Travis\Resource\EnvironmentVariableInterface;
use React\Promise\PromiseInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\reject;
use function React\Promise\resolve;

class EnvironmentVariable extends BaseEnvironmentVariable
{
    public function refresh() : PromiseInterface
    {
        return Promise::fromObservable(unwrapObservableFromPromise($this->handleCommand(
            new VarsCommand($this->repositoryId())
        ))->filter(function (EnvironmentVariableInterface $var) {
            return $this->id() === $var->id();
        }))->then(function ($var) {
            if ($var === null) {
                return reject();
            }

            return resolve($var);
        });
    }
}
