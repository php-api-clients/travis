<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\SSHKeyCommand;
use ApiClients\Client\Travis\CommandBus\Handler\SSHKeyHandler;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
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
        $json = [
            'foo' => 'bar',
        ];
        $repositoryId = 123;
        $command = new SSHKeyCommand($repositoryId);

        $client = $this->prophesize(ClientInterface::class);
        $client->request(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->shouldBeCalled()->willReturn(resolve(
            new Response(
                200,
                [],
                new JsonStream(['ssh_key' => $json])
            )
        ));

        $requestService = new RequestService($client->reveal());

        $hydrator = $this->prophesize(Hydrator::class);
        $hydrator->hydrate(
            Argument::exact(SSHKeyInterface::HYDRATE_CLASS),
            Argument::exact($json)
        )->shouldBeCalled()->willReturn($sshKeyResource);

        $handler = new SSHKeyHandler($requestService, $hydrator->reveal());

        self::assertSame($sshKeyResource, await($handler->handle($command), Factory::create()));
    }
}
