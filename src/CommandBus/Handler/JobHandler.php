<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\JobCommand;
use ApiClients\Client\Travis\Resource\JobInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class JobHandler
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
     * @param JobCommand $command
     * @return PromiseInterface
     */
    public function handle(JobCommand $command): PromiseInterface
    {
        return $this->service->fetch(
            'jobs/' . (string)$command->getId(),
            'job',
            JobInterface::HYDRATE_CLASS
        );
    }
}
