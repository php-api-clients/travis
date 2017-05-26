<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryCommand;
use ApiClients\Client\Travis\CommandBus\Handler\RepositoryHandler;
use ApiClients\Client\Travis\Exception\RepositoryDoesNotExist;
use ApiClients\Client\Travis\Resource\Async\EmptyRepository;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Middleware\Json\JsonStream;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\TestUtilities\TestCase;
use Clue\React\Buzz\Message\ResponseException;
use React\EventLoop\Factory;
use RingCentral\Psr7\Response;
use function Clue\React\Block\await;
use function React\Promise\reject;
use function React\Promise\resolve;

final class RepositoryHandlerTest extends TestCase
{
    public function testRepository()
    {
        $repositoryResource = $this->prophesize(RepositoryInterface::class)->reveal();

        $repository = 'wyrihaximus/tactician-command-handler-mapper';
        $command = new RepositoryCommand($repository);

        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->fetch('repos/wyrihaximus/tactician-command-handler-mapper', 'repo', RepositoryInterface::HYDRATE_CLASS)->shouldBeCalled()->willReturn(resolve($repositoryResource));

        $handler = new RepositoryHandler($service->reveal());

        self::assertSame($repositoryResource, await($handler->handle($command), Factory::create()));
    }

    public function testNoRepository()
    {
        $this->expectException(RepositoryDoesNotExist::class);

        $repositoryResource = $this->prophesize(EmptyRepository::class)->reveal();

        $repository = 'wyrihaximus/tactician-command-handler-mapper';
        $command = new RepositoryCommand($repository);

        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->fetch('repos/wyrihaximus/tactician-command-handler-mapper', 'repo', RepositoryInterface::HYDRATE_CLASS)->shouldBeCalled()->willReturn(resolve($repositoryResource));

        $handler = new RepositoryHandler($service->reveal());

        await($handler->handle($command), Factory::create());
    }

    public function test404()
    {
        $this->expectException(RepositoryDoesNotExist::class);

        $repository = 'wyrihaximus/tactician-command-handler-mapper';
        $command = new RepositoryCommand($repository);

        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->fetch('repos/wyrihaximus/tactician-command-handler-mapper', 'repo', RepositoryInterface::HYDRATE_CLASS)->shouldBeCalled()->willReturn(reject(
            new ResponseException(
                new Response(
                    404,
                    [],
                    new JsonStream([])
                )
            )
        ));

        $handler = new RepositoryHandler($service->reveal());

        await($handler->handle($command), Factory::create());
    }
}
