<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryIdCommand;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use React\Promise\PromiseInterface;

final class RepositoryIdHandler
{
    /**
     * @var FetchAndHydrateService
     */
    private $hydrateService;

    /**
     * @param FetchAndHydrateService $hydrateService
     */
    public function __construct(FetchAndHydrateService $hydrateService)
    {
        $this->hydrateService = $hydrateService;
    }

    /**
     * Fetch the given repository and hydrate it.
     *
     * @param  RepositoryIdCommand $command
     * @return PromiseInterface
     */
    public function handle(RepositoryIdCommand $command): PromiseInterface
    {
        return $this->hydrateService->fetch(
            'repos/' . (string)$command->getRepositoryId(),
            'repo',
            RepositoryInterface::HYDRATE_CLASS
        );
    }
}
