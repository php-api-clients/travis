<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;
use WyriHaximus\Travis\Resource\EnvironmentVariable as BaseEnvironmentVariable;

class EnvironmentVariable extends BaseEnvironmentVariable
{
    public function refresh() : PromiseInterface
    {
        return $this->getTransport()->request('settings/env_vars?repository_id=' . $this->repositoryId())->then(function ($json) {
            foreach ($json['env_vars'] as $envVar) {
                if ($envVar['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->getTransport()->getHydrator()->hydrate('EnvironmentVariable', $envVar));
            }

            return reject();
        });
    }
}
