<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\SettingsCommand;
use ApiClients\Client\Travis\Resource\SettingsInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use React\Promise\PromiseInterface;

final class SettingsHandler
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
     * Fetch the given repository and hydrate it.
     *
     * @param  SettingsCommand  $command
     * @return PromiseInterface
     */
    public function handle(SettingsCommand $command): PromiseInterface
    {
        return $this->service->fetch(
            'repos/' . $command->getRepositoryId() . '/settings',
            'settings',
            SettingsInterface::HYDRATE_CLASS
        );
    }
}
