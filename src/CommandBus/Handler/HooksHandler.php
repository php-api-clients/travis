<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\HooksCommand;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

final class HooksHandler
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
     * Fetch the given repository and hydrate it.
     *
     * @param  HooksCommand     $command
     * @return PromiseInterface
     */
    public function handle(HooksCommand $command): PromiseInterface
    {
        return resolve($this->fetchAndIterateService->iterate('hooks', 'hooks', HookInterface::HYDRATE_CLASS));
    }
}
