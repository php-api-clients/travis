<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BuildCommand;
use ApiClients\Client\Travis\CommandBus\Handler\BuildHandler;
use ApiClients\Client\Travis\Resource\BuildInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class BuildHandlerTest extends TestCase
{
    public function testRepositoryKey()
    {
        $command = new BuildCommand(123);
        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->fetch('builds/123', 'build', BuildInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new BuildHandler($service->reveal());
        $handler->handle($command);
    }
}
