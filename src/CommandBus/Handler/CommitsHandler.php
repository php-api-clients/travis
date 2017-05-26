<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\CommitsCommand;
use ApiClients\Client\Travis\Resource\CommitInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

final class CommitsHandler
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
     * @param  CommitsCommand   $command
     * @return PromiseInterface
     */
    public function handle(CommitsCommand $command): PromiseInterface
    {
        return resolve($this->service->iterate(
            'repos/' . $command->getRepository() . '/builds',
            'commits',
            CommitInterface::HYDRATE_CLASS
        ));
    }
}
