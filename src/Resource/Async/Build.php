<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\BuildCommand;
use ApiClients\Client\Travis\CommandBus\Command\JobCommand;
use ApiClients\Client\Travis\CommandBus\Command\JobsCommand;
use ApiClients\Client\Travis\Resource\Build as BaseBuild;
use React\Promise\PromiseInterface;
use Rx\ObservableInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;

class Build extends BaseBuild
{
    /**
     * @return ObservableInterface
     */
    public function jobs(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new JobsCommand($this->id())
        ));
    }

    /**
     * @param  int              $id
     * @return PromiseInterface
     */
    public function job(int $id): PromiseInterface
    {
        return $this->handleCommand(new JobCommand($id));
    }

    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(new BuildCommand($this->id()));
    }
}
