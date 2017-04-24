<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryKeyCommand;
use ApiClients\Client\Travis\CommandBus\Command\SettingsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\RepositoryKeyHandler;
use ApiClients\Client\Travis\CommandBus\Handler\SettingsHandler;
use ApiClients\Client\Travis\Resource\RepositoryKeyInterface;
use ApiClients\Client\Travis\Resource\SettingsInterface;
use ApiClients\Foundation\Hydrator\Hydrator;
use ApiClients\Foundation\Transport\ClientInterface;
use ApiClients\Foundation\Transport\JsonStream;
use ApiClients\Foundation\Transport\Service\RequestService;
use ApiClients\Tools\Services\Client\FetchAndHydrateService;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use React\EventLoop\Factory;
use RingCentral\Psr7\Response;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class SettingsHandlerTest extends TestCase
{
    public function testRepositoryKey()
    {
        $command = new SettingsCommand(123);
        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->fetch('repos/123/settings', 'settings', SettingsInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new SettingsHandler($service->reveal());
        $handler->handle($command);
    }
}
