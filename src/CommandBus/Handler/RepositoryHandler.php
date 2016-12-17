<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryCommand;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Foundation\Hydrator\Hydrator;
use ApiClients\Foundation\Transport\Service\RequestService;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use RingCentral\Psr7\Request;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class RepositoryHandler
{
    /**
     * @var RequestService
     */
    private $requestService;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @param RequestService $requestService
     * @param Hydrator $hydrator
     */
    public function __construct(RequestService $requestService, Hydrator $hydrator)
    {
        $this->requestService = $requestService;
        $this->hydrator = $hydrator;
    }

    /**
     * Fetch the given repository and hydrate it
     *
     * @param RepositoryCommand $command
     * @return PromiseInterface
     */
    public function handle(RepositoryCommand $command): PromiseInterface
    {
        return $this->requestService->handle(
            new Request('GET', 'repos/' . $command->getRepository())
        )->then(function (ResponseInterface $response) {
            return resolve($this->hydrator->hydrate(
                RepositoryInterface::HYDRATE_CLASS,
                $response->getBody()->getJson()['repo']
            ));
        });
    }
}
