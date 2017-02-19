<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryCommand;
use ApiClients\Client\Travis\Exception\RepositoryDoesNotExist;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Foundation\Resource\EmptyResourceInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use Clue\React\Buzz\Message\ResponseException;
use React\Promise\PromiseInterface;
use Throwable;
use function React\Promise\reject;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class RepositoryHandler
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
     * @param RepositoryCommand $command
     * @return PromiseInterface
     */
    public function handle(RepositoryCommand $command): PromiseInterface
    {
        return $this->service->handle(
            'repos/' . $command->getRepository(),
            'repo',
            RepositoryInterface::HYDRATE_CLASS
        )->then(function (RepositoryInterface $repository) use ($command) {
            if ($repository instanceof EmptyResourceInterface) {
                return reject(RepositoryDoesNotExist::create($command->getRepository()));
            }

            return resolve($repository);
        }, function (Throwable $throwable) use ($command) {
            if (!($throwable instanceof ResponseException)) {
                return reject($throwable);
            }

            if ($throwable->getCode() !== 404) {
                return reject($throwable);
            }

            return reject(RepositoryDoesNotExist::create($command->getRepository()));
        });
    }
}
