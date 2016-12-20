<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\HooksCommand;
use ApiClients\Client\Travis\CommandBus\Handler\HooksHandler;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class HooksHandlerTest extends TestCase
{
    public function testHooks()
    {
        $command = new HooksCommand();
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->handle('hooks', 'hooks', HookInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new HooksHandler($service->reveal());
        $handler->handle($command);
    }
}
