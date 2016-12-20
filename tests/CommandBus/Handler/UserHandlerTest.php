<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\UserCommand;
use ApiClients\Client\Travis\CommandBus\Handler\UserHandler;
use ApiClients\Client\Travis\Resource\UserInterface;
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
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class UserHandlerTest extends TestCase
{
    public function testUser()
    {
        $userResource = $this->prophesize(UserInterface::class)->reveal();
        $json = [
            'foo' => 'bar',
        ];
        $command = new UserCommand();

        $client = $this->prophesize(ClientInterface::class);
        $client->request(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->shouldBeCalled()->willReturn(resolve(
            new Response(
                200,
                [],
                new JsonStream(['user' => $json])
            )
        ));

        $requestService = new RequestService($client->reveal());

        $hydrator = $this->prophesize(Hydrator::class);
        $hydrator->hydrate(
            Argument::exact(UserInterface::HYDRATE_CLASS),
            Argument::exact($json)
        )->shouldBeCalled()->willReturn($userResource);

        $handler = new UserHandler(new FetchAndHydrateService($requestService, $hydrator->reveal()));

        self::assertSame($userResource, await($handler->handle($command), Factory::create()));
    }
}
