<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Service;

use ApiClients\Client\Travis\CommandBus\Command\BroadcastsCommand;
use ApiClients\Client\Travis\Resource\BroadcastInterface;
use ApiClients\Foundation\Hydrator\Hydrator;
use ApiClients\Foundation\Service\ServiceInterface;
use ApiClients\Foundation\Transport\Service\RequestService;
use Psr\Http\Message\ResponseInterface;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;
use RingCentral\Psr7\Request;
use Rx\Observable;
use Rx\React\Promise;
use function React\Promise\resolve;
use function WyriHaximus\React\futureFunctionPromise;

final class FetchAndIterateService implements ServiceInterface
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
     * @param string|null $path
     * @param string|null $index
     * @param string|null $hydrateClass
     * @return CancellablePromiseInterface
     */
    public function handle(
        string $path = null,
        string $index = null,
        string $hydrateClass = null
    ): CancellablePromiseInterface {
        return resolve(
            Promise::toObservable(
                $this->requestService->handle(
                    new Request('GET', $path)
                )
            )->flatMap(function ($response) use ($index) {
                return Observable::fromArray($response->getBody()->getJson()[$index]);
            })->map(function ($json) use ($hydrateClass) {
                return $this->hydrator->hydrate(
                    $hydrateClass,
                    $json
                );
            })
        );
    }
}
