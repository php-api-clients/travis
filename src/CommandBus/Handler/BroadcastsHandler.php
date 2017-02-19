<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BroadcastsCommand;
use ApiClients\Client\Travis\Resource\BroadcastInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class BroadcastsHandler
{
    /**
     * @var FetchAndIterateService
     */
    private $fetchAndIterateService;

    /**
     * @param FetchAndIterateService $fetchAndIterateService
     */
    public function __construct(FetchAndIterateService $fetchAndIterateService)
    {
        $this->fetchAndIterateService = $fetchAndIterateService;
    }

    /**
     * Fetch the given repository and hydrate it
     *
     * @param BroadcastsCommand $command
     * @return PromiseInterface
     */
    public function handle(BroadcastsCommand $command): PromiseInterface
    {
        return $this->fetchAndIterateService->handle('broadcasts', 'broadcasts', BroadcastInterface::HYDRATE_CLASS);
    }
}
