<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\UserCommand;
use ApiClients\Client\Travis\Resource\UserInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class UserHandler
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
     * @param UserCommand $command
     * @return PromiseInterface
     */
    public function handle(UserCommand $command): PromiseInterface
    {
        return $this->service->fetch('users', 'user', UserInterface::HYDRATE_CLASS);
    }
}
