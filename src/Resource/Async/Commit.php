<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Commit as BaseCommit;
use function React\Promise\resolve;

class Commit extends BaseCommit
{
    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('builds/' . $this->id)
        )->then(function (ResponseInterface $response) {
            return resolve($this->handleCommand(new HydrateCommand('Build', $response->getBody()->getJosn()['build'])));
        });
    }
}
