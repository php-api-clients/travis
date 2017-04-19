<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BranchesCommand;
use ApiClients\Client\Travis\Resource\BranchInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class BranchesHandler
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
     * Fetch the given repository and hydrate it
     *
     * @param BranchesCommand $command
     * @return PromiseInterface
     */
    public function handle(BranchesCommand $command): PromiseInterface
    {
        return resolve($this->service->iterate(
            'repos/' . (string)$command->getRepositoryId() . '/branches',
            'branches',
            BranchInterface::HYDRATE_CLASS
        ));
    }
}
