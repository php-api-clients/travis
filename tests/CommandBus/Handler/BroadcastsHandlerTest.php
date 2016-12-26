<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BroadcastsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\BroadcastsHandler;
use ApiClients\Client\Travis\Resource\BroadcastInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class BroadcastsHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new BroadcastsCommand();
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->handle('broadcasts', 'broadcasts', BroadcastInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new BroadcastsHandler($service->reveal());
        $handler->handle($command);
    }
}
