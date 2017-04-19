<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BuildsCommand;
use ApiClients\Client\Travis\Resource\BuildInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class BuildsHandler
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
     * @param BuildsCommand $command
     * @return PromiseInterface
     */
    public function handle(BuildsCommand $command): PromiseInterface
    {
        return resolve($this->service->iterate(
            'repos/' . $command->getRepository() . '/builds',
            'builds',
            BuildInterface::HYDRATE_CLASS
        ));
    }
}
