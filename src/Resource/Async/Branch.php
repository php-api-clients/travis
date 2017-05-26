<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\BranchesCommand;
use ApiClients\Client\Travis\Resource\Branch as BaseBranch;
use ApiClients\Client\Travis\Resource\BranchInterface;
use React\Promise\PromiseInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\reject;
use function React\Promise\resolve;

class Branch extends BaseBranch
{
    /**
     * @return PromiseInterface
     */
    public function refresh(): PromiseInterface
    {
        return Promise::fromObservable(unwrapObservableFromPromise($this->handleCommand(
            new BranchesCommand($this->repositoryId())
        ))->filter(function (BranchInterface $branch) {
            return $this->id() === $branch->id();
        }))->then(function ($branch) {
            if ($branch === null) {
                return reject();
            }

            return resolve($branch);
        });
    }
}
