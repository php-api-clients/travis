<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\BuildCommand;
use ApiClients\Client\Travis\CommandBus\Command\JobsCommand;
use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use ApiClients\Client\Travis\Resource\Build as BaseBuild;
use function React\Promise\resolve;
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
     * @param int $id
     * @return PromiseInterface
     */
    public function job(int $id): PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('jobs/' . $id)
        )->then(function (ResponseInterface $response) {
            return $this->handleCommand(
                new HydrateCommand('Job', $response->getBody()->getJson()['job'])
            );
        });
    }

    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(new BuildCommand($this->id()));
    }
}
