<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Broadcast as BaseBroadcast;
use function React\Promise\reject;
use function React\Promise\resolve;

class Broadcast extends BaseBroadcast
{
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('repos/' . $this->repositoryId() . '/branches')
        )->then(function ($json) {
            foreach ($json['broadcasts'] as $broadcast) {
                if ($broadcast['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->handleCommand(new HydrateCommand('Broadcast', $broadcast)));
            }

            return reject();
        });
    }
}
