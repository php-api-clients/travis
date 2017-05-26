<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\AnnotationsCommand;
use ApiClients\Client\Travis\CommandBus\Command\JobCommand;
use ApiClients\Client\Travis\CommandBus\Command\JobLogCommand;
use ApiClients\Client\Travis\Resource\Job as BaseJob;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;

class Job extends BaseJob
{
    public function log(): Observable
    {
        return unwrapObservableFromPromise(
            $this->handleCommand(new JobLogCommand($this->id()))
        );
    }

    /**
     * @return ObservableInterface
     */
    public function annotations(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new AnnotationsCommand($this->id())
        ));
    }

    /**
     * @return PromiseInterface
     */
    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(new JobCommand($this->id()));
    }
}
