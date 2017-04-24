<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\SSHKeyCommand;
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

final class SSHKeyHandlerTest extends TestCase
{
    public function testSSHKey()
    {
        $sshKeyResource = $this->prophesize(SSHKeyInterface::class)->reveal();
        $repositoryId = 123;
        $command = new SSHKeyCommand($repositoryId);

        $service = $this->prophesize(FetchAndHydrateService::class);
        $service->fetch('settings/ssh_key/123', 'ssh_key', SSHKeyInterface::HYDRATE_CLASS)->shouldBeCalled()->willReturn(resolve($sshKeyResource));

        $handler = new SSHKeyHandler($service->reveal());

        self::assertSame($sshKeyResource, await($handler->handle($command), Factory::create()));
    }
}
