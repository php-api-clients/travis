<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\AccountsCommand;
use ApiClients\Client\Travis\CommandBus\Command\CachesCommand;
use ApiClients\Client\Travis\CommandBus\Handler\AccountsHandler;
use ApiClients\Client\Travis\CommandBus\Handler\CachesHandler;
use ApiClients\Client\Travis\Resource\AccountInterface;
use ApiClients\Client\Travis\Resource\CacheInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class CachesHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new CachesCommand(123);
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->iterate('repos/123/caches', 'caches', CacheInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new CachesHandler($service->reveal());
        $handler->handle($command);
    }
}
