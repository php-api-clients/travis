<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\CachesCommand;
use ApiClients\Client\Travis\Resource\CacheInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class CachesHandler
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
     * @param CachesCommand $command
     * @return PromiseInterface
     */
    public function handle(CachesCommand $command): PromiseInterface
    {
        return resolve($this->service->iterate(
            'repos/' . (string)$command->getRepositoryId() . '/caches',
            'caches',
            CacheInterface::HYDRATE_CLASS
        ));
    }
}
