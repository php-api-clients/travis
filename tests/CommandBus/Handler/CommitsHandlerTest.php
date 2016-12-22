<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\CommitsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\CommitsHandler;
use ApiClients\Client\Travis\Resource\CommitInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class CommitsHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new CommitsCommand('api-clients/travis');
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->handle('repos/api-clients/travis/builds', 'commits', CommitInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new CommitsHandler($service->reveal());
        $handler->handle($command);
    }
}
