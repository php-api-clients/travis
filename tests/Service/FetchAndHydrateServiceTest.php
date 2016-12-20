<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Service;

use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Client\Travis\Service\FetchAndHydrateService;
use ApiClients\Foundation\Hydrator\Hydrator;
use ApiClients\Foundation\Transport\ClientInterface;
use ApiClients\Foundation\Transport\JsonStream;
use ApiClients\Foundation\Transport\Service\RequestService;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use React\EventLoop\Factory;
use RingCentral\Psr7\Response;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class FetchAndHydrateServiceTest extends TestCase
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
                    'repo' => [
                        'slug' => 'slak',
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

        $service = new FetchAndHydrateService($requestService, $hydrator->reveal());
        $resource = await(
            $service->handle('repo', 'repo', RepositoryInterface::HYDRATE_CLASS),
            Factory::create()
        );

        self::assertSame($repositoryResource, $resource);
    }
}
