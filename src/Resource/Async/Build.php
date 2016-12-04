<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Build as BaseBuild;
use function React\Promise\resolve;

class Build extends BaseBuild
{
    /**
     * @return ObservableInterface
     */
    public function jobs(): ObservableInterface
    {
        return Promise::toObservable(
            $this->handleCommand(new SimpleRequestCommand('builds/' . $this->id()))
        )->flatMap(function ($response) {
            return Observable::fromArray($response->getBody()->getJson()['jobs']);
        })->flatMap(function ($job) {
            return Promise::toObservable($this->handleCommand(new HydrateCommand('Job', $job)));
        });
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
        return $this->handleCommand(
            new SimpleRequestCommand('builds/' . $this->id)
        )->then(function (ResponseInterface $response) {
            return resolve($this->handleCommand(
                new SimpleRequestCommand('Build', $response->getBody()->getJson()['build'])
            ));
        });
    }
}
