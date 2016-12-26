<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\AnnotationsCommand;
use ApiClients\Client\Travis\Resource\AnnotationInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class AnnotationsHandler
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
     * @param AnnotationsCommand $command
     * @return PromiseInterface
     */
    public function handle(AnnotationsCommand $command): PromiseInterface
    {
        return $this->service->handle(
            'jobs/' . (string)$command->getRepositoryId() . '/annotations',
            'annotations',
            AnnotationInterface::HYDRATE_CLASS
        );
    }
}
