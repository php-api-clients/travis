<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\EnvironmentVariable as BaseEnvironmentVariable;
use function React\Promise\reject;
use function React\Promise\resolve;

class EnvironmentVariable extends BaseEnvironmentVariable
{
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(new SimpleRequestCommand(
            'settings/env_vars?repository_id=' . $this->repositoryId()
        ))->then(function ($json) {
            foreach ($json['env_vars'] as $envVar) {
                if ($envVar['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->handleCommand(new HydrateCommand(
                    'EnvironmentVariable',
                    $envVar
                )));
            }

            return reject();
        });
    }
}
