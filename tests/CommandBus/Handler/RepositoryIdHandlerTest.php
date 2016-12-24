<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryIdCommand;
use ApiClients\Client\Travis\CommandBus\Command\SSHKeyCommand;
use ApiClients\Client\Travis\CommandBus\Handler\RepositoryIdHandler;
use ApiClients\Client\Travis\CommandBus\Handler\SSHKeyHandler;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Foundation\Hydrator\Hydrator;
use ApiClients\Foundation\Transport\ClientInterface;
use ApiClients\Foundation\Transport\JsonStream;
use ApiClients\Foundation\Transport\Service\RequestService;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use React\EventLoop\Factory;
use RingCentral\Psr7\Response;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class RepositoryIdHandlerTest extends TestCase
{
    public function testRepositoryId()
    {
        $command = new RepositoryIdCommand(123);
        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->handle('jobs/123', 'job', JobInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new RepositoryIdHandler($service->reveal());
        $handler->handle($command);
    }
}
