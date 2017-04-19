<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\UserCommand;
use ApiClients\Client\Travis\CommandBus\Handler\UserHandler;
use ApiClients\Client\Travis\Resource\UserInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\TestUtilities\TestCase;
use React\EventLoop\Factory;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class UserHandlerTest extends TestCase
{
    public function testUser()
    {
        $userResource = $this->prophesize(UserInterface::class)->reveal();

        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->fetch('users', 'user', UserInterface::HYDRATE_CLASS)->shouldBeCalled()->willReturn(resolve($userResource));

        $command = new UserCommand();
        $handler = new UserHandler($service->reveal());

        self::assertSame($userResource, await($handler->handle($command), Factory::create()));
    }
}
