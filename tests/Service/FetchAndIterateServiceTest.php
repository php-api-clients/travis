<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Service;

use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Client\Travis\Service\FetchAndIterateService;
use ApiClients\Foundation\Hydrator\Hydrator;
use ApiClients\Foundation\Transport\ClientInterface;
use ApiClients\Foundation\Transport\JsonStream;
use ApiClients\Foundation\Transport\Service\RequestService;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use React\EventLoop\Factory;
use RingCentral\Psr7\Request;
use ApiClients\Client\Travis\Middleware\TokenAuthorizationHeaderMiddleware;
use ApiClients\Client\Travis\Options;
use function Clue\React\Block\await;
use function React\Promise\resolve;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use RingCentral\Psr7\Response;

final class FetchAndIterateServiceTest extends TestCase
{
    public function testHandle()
    {
        $repositoryResource = $this->prophesize(RepositoryInterface::class)->reveal();

        $client = $this->prophesize(ClientInterface::class);
        $client->request(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->shouldBeCalled()->willReturn(resolve(
            new Response(
                200,
                [],
                new JsonStream([
                    'repos' => [
                        [
                            'slug' => 'slak',
                        ],
                        [
                            'slug' => 'vis',
                        ],
                        [
                            'slug' => 'beer',
                        ],
                    ],
                ])
            )
        ));

        $requestService = new RequestService($client->reveal());

        $hydrator = $this->prophesize(Hydrator::class);
        $hydrator->hydrate(
            Argument::exact(RepositoryInterface::HYDRATE_CLASS),
            Argument::exact([
                'slug' => 'slak',
            ])
        )->shouldBeCalled()->willReturn($repositoryResource);
        $hydrator->hydrate(
            Argument::exact(RepositoryInterface::HYDRATE_CLASS),
            Argument::exact([
                'slug' => 'vis',
            ])
        )->shouldBeCalled()->willReturn($repositoryResource);
        $hydrator->hydrate(
            Argument::exact(RepositoryInterface::HYDRATE_CLASS),
            Argument::exact([
                'slug' => 'beer',
            ])
        )->shouldBeCalled()->willReturn($repositoryResource);

        $subscribeCallbackCalled = false;
        $service = new FetchAndIterateService($requestService, $hydrator->reveal());
        unwrapObservableFromPromise(
            $service->handle('repos', 'repos', RepositoryInterface::HYDRATE_CLASS)
        )->subscribeCallback(function ($resource) use ($repositoryResource, &$subscribeCallbackCalled) {
            self::assertSame($repositoryResource, $resource);
            $subscribeCallbackCalled = true;
        });

        self::assertTrue($subscribeCallbackCalled);
    }
}
