<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BuildCommand;
use ApiClients\Client\Travis\Resource\BuildInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class BuildHandler
{
    /**
     * @var FetchAndHydrateService
     */
    private $service;

    /**
     * @param FetchAndHydrateService $service
     */
    public function __construct(FetchAndHydrateService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch the given repository and hydrate it
     *
     * @param BuildCommand $command
     * @return PromiseInterface
     */
    public function handle(BuildCommand $command): PromiseInterface
    {
        return $this->service->fetch(
            'builds/' . (string)$command->getId(),
            'build',
            BuildInterface::HYDRATE_CLASS
        );
    }
}
