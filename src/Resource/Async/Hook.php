<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\Promise\PromiseInterface;
use ApiClients\Client\Travis\Resource\Hook as BaseHook;
use function React\Promise\reject;
use function React\Promise\resolve;

class Hook extends BaseHook
{
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(new SimpleRequestCommand('hooks'))->then(function ($json) {
            foreach ($json['hooks'] as $hook) {
                if ($hook['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->handleCommand(new HydrateCommand('Hook', $hook)));
            }

            return reject();
        });
    }
}
