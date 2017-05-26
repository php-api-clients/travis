<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\JobsCommand;
use ApiClients\Client\Travis\Resource\JobInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

final class JobsHandler
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
     * @param  JobsCommand      $command
     * @return PromiseInterface
     */
    public function handle(JobsCommand $command): PromiseInterface
    {
        return resolve($this->service->iterate(
            'builds/' . (string)$command->getBuildId(),
            'jobs',
            JobInterface::HYDRATE_CLASS
        ));
    }
}
