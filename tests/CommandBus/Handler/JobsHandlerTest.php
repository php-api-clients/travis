<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\JobsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\JobsHandler;
use ApiClients\Client\Travis\Resource\JobInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class JobsHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new JobsCommand(123);
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->handle('builds/123', 'jobs', JobInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new JobsHandler($service->reveal());
        $handler->handle($command);
    }
}
