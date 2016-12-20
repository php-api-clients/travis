<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\SSHKeyCommand;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
use ApiClients\Client\Travis\Service\FetchAndHydrateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class SSHKeyHandler
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
     * @param SSHKeyCommand $command
     * @return PromiseInterface
     */
    public function handle(SSHKeyCommand $command): PromiseInterface
    {
        return $this->service->handle(
            'settings/ssh_key/' . (string) $command->getId(),
            'ssh_key',
            SSHKeyInterface::HYDRATE_CLASS
        );
    }
}
