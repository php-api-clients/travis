<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\VarsCommand;
use ApiClients\Client\Travis\Resource\EnvironmentVariableInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

final class VarsHandler
{
    /**
     * @var FetchAndHydrateService
     */
    private $service;

    /**
     * @param FetchAndIterateService $service
     */
    public function __construct(FetchAndIterateService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch the given repository and hydrate it.
     *
     * @param  VarsCommand      $command
     * @return PromiseInterface
     */
    public function handle(VarsCommand $command): PromiseInterface
    {
        return resolve($this->service->iterate(
            'settings/env_vars?repository_id=' . (string)$command->getRepositoryId(),
            'env_vars',
            EnvironmentVariableInterface::HYDRATE_CLASS
        ));
    }
}
