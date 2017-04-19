<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\BranchesCommand;
use ApiClients\Client\Travis\CommandBus\Handler\BranchesHandler;
use ApiClients\Client\Travis\Resource\BranchInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class BranchesHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new BranchesCommand(123);
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->iterate('repos/123/branches', 'branches', BranchInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new BranchesHandler($service->reveal());
        $handler->handle($command);
    }
}
