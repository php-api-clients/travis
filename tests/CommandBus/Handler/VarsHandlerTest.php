<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\AccountsCommand;
use ApiClients\Client\Travis\CommandBus\Command\CachesCommand;
use ApiClients\Client\Travis\CommandBus\Command\VarsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\AccountsHandler;
use ApiClients\Client\Travis\CommandBus\Handler\CachesHandler;
use ApiClients\Client\Travis\CommandBus\Handler\VarsHandler;
use ApiClients\Client\Travis\Resource\AccountInterface;
use ApiClients\Client\Travis\Resource\CacheInterface;
use ApiClients\Client\Travis\Resource\EnvironmentVariableInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;
use function React\Promise\resolve;
use Rx\Observable;

final class VarsHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new VarsCommand(123);
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->iterate(
            'settings/env_vars?repository_id=123',
            'env_vars',
            EnvironmentVariableInterface::HYDRATE_CLASS
        )->shouldBeCalled()->willReturn(Observable::fromArray([]));
        $handler = new VarsHandler($service->reveal());
        $handler->handle($command);
    }
}
