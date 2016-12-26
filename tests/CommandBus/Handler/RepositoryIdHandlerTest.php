<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryIdCommand;
use ApiClients\Client\Travis\CommandBus\Handler\RepositoryIdHandler;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class RepositoryIdHandlerTest extends TestCase
{
    public function testRepositoryId()
    {
        $command = new RepositoryIdCommand(123);
        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->handle('repos/123', 'repo', RepositoryInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new RepositoryIdHandler($service->reveal());
        $handler->handle($command);
    }
}
