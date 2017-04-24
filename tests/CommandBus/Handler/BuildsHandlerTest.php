<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BuildsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\BuildsHandler;
use ApiClients\Client\Travis\Resource\BuildInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class BuildsHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new BuildsCommand('api-clients/travis');
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->iterate(
            'repos/api-clients/travis/builds',
            'builds',
            BuildInterface::HYDRATE_CLASS
        )->shouldBeCalled();
        $handler = new BuildsHandler($service->reveal());
        $handler->handle($command);
    }
}
