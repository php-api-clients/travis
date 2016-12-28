<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis;

use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\CommandBus\Command;
use ApiClients\Foundation\ClientInterface;
use ApiClients\Tools\TestUtilities\TestCase;
use Prophecy\Argument;
use React\EventLoop\Factory;
use function Clue\React\Block\await;
use function React\Promise\resolve;
use Rx\React\Promise;

final class AsyncClientTest extends TestCase
{
    public function testRepository()
    {
        $expected = 'foo.bar';
        $loop = Factory::create();
        $client = $this->prophesize(ClientInterface::class);
        $client->handle(
            Argument::which('getRepository', 'php-api-clients/travis')
        )->shouldBeCalled()->willReturn(resolve($expected));

        $asyncClient = new AsyncClient($loop, 'token', [], $client->reveal());
        $result = await($asyncClient->repository('php-api-clients/travis'), $loop);
        self::assertSame($expected, $result);
    }

    public function testHooks()
    {
        $expected = 'foo.bar';
        $loop = Factory::create();
        $client = $this->prophesize(ClientInterface::class);
        $client->handle(
            Argument::type(Command\HooksCommand::class)
        )->shouldBeCalled()->willReturn(resolve(Promise::toObservable(resolve($expected))));

        $asyncClient = new AsyncClient($loop, 'token', [], $client->reveal());
        $result = await(Promise::fromObservable($asyncClient->hooks()), $loop);
        self::assertSame($expected, $result);
    }

    public function testAccounts()
    {
        $expected = 'foo.bar';
        $loop = Factory::create();
        $client = $this->prophesize(ClientInterface::class);
        $client->handle(
            Argument::type(Command\AccountsCommand::class)
        )->shouldBeCalled()->willReturn(resolve(Promise::toObservable(resolve($expected))));

        $asyncClient = new AsyncClient($loop, 'token', [], $client->reveal());
        $result = await(Promise::fromObservable($asyncClient->accounts()), $loop);
        self::assertSame($expected, $result);
    }
}
