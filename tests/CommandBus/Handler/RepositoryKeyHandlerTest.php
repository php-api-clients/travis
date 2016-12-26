<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryKeyCommand;
use ApiClients\Client\Travis\CommandBus\Handler\RepositoryKeyHandler;
use ApiClients\Client\Travis\Resource\RepositoryKeyInterface;
use ApiClients\Foundation\Hydrator\Hydrator;
use ApiClients\Foundation\Transport\ClientInterface;
use ApiClients\Foundation\Transport\JsonStream;
use ApiClients\Foundation\Transport\Service\RequestService;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use React\EventLoop\Factory;
use RingCentral\Psr7\Response;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class RepositoryKeyHandlerTest extends TestCase
{
    public function testRepositoryKey()
    {
        $repositoryResource = $this->prophesize(RepositoryKeyInterface::class)->reveal();
        $json = [
            'foo' => 'bar',
        ];
        $repository = 'wyrihaximus/tactician-command-handler-mapper';
        $command = new RepositoryKeyCommand($repository);

        $client = $this->prophesize(ClientInterface::class);
        $client->request(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->shouldBeCalled()->willReturn(resolve(
            new Response(
                200,
                [],
                new JsonStream($json)
            )
        ));

        $requestService = new RequestService($client->reveal());

        $hydrator = $this->prophesize(Hydrator::class);
        $hydrator->hydrate(
            Argument::exact(RepositoryKeyInterface::HYDRATE_CLASS),
            Argument::exact($json)
        )->shouldBeCalled()->willReturn($repositoryResource);

        $handler = new RepositoryKeyHandler(new FetchAndHydrateService($requestService, $hydrator->reveal()));

        self::assertSame($repositoryResource, await($handler->handle($command), Factory::create()));
    }
}
