<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryKeyCommand;
use ApiClients\Client\Travis\Resource\RepositoryKeyInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class RepositoryKeyHandler
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
     * @param RepositoryKeyCommand $command
     * @return PromiseInterface
     */
    public function handle(RepositoryKeyCommand $command): PromiseInterface
    {
        return $this->service->fetch(
            'repos/' . $command->getRepository() . '/key',
            '',
            RepositoryKeyInterface::HYDRATE_CLASS
        );
    }
}
