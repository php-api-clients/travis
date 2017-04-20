<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis;

use ApiClients\Client\Travis\AsyncClientInterface;
use ApiClients\Client\Travis\Client;
use ApiClients\Client\Travis\ClientInterface;
use ApiClients\Client\Travis\Resource\AccountInterface;
use ApiClients\Client\Travis\Resource\BroadcastInterface;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
use ApiClients\Client\Travis\Resource\UserInterface;
use ApiClients\Tools\TestUtilities\TestCase;
use React\EventLoop\Factory;
use Rx\Observable;
use Rx\Scheduler\ImmediateScheduler;
use function React\Promise\resolve;

final class ClientTest extends TestCase
{
    public function testCreate()
    {
        $client = Client::create();

        self::assertInstanceOf(ClientInterface::class, $client);
        self::assertInstanceOf(Client::class, $client);
    }

    public function testCreateFromClient()
    {
        $client = Client::createFromClient(Factory::create(), $this->prophesize(AsyncClientInterface::class)->reveal());

        self::assertInstanceOf(ClientInterface::class, $client);
        self::assertInstanceOf(Client::class, $client);
    }

    public function testRepository()
    {
        $repositorySlug = 'php-api-clients/travis';
        $repository = $this->prophesize(RepositoryInterface::class)->reveal();

        $loop = Factory::create();
        $asyncClient = $this->prophesize(AsyncClientInterface::class);
        $asyncClient->repository($repositorySlug)->shouldBeCalled()->willReturn(resolve($repository));

        $client = Client::createFromClient($loop, $asyncClient->reveal());

        $result = $client->repository($repositorySlug);

        self::assertSame($repository, $result);
    }

    public function testUser()
    {
        $user = $this->prophesize(UserInterface::class)->reveal();

        $loop = Factory::create();
        $asyncClient = $this->prophesize(AsyncClientInterface::class);
        $asyncClient->user()->shouldBeCalled()->willReturn(resolve($user));

        $client = Client::createFromClient($loop, $asyncClient->reveal());

        $result = $client->user();

        self::assertSame($user, $result);
    }

    public function testSshKey()
    {
        $sshKeyId = 1337;
        $sshKey = $this->prophesize(SSHKeyInterface::class)->reveal();

        $loop = Factory::create();
        $asyncClient = $this->prophesize(AsyncClientInterface::class);
        $asyncClient->sshKey($sshKeyId)->shouldBeCalled()->willReturn(resolve($sshKey));

        $client = Client::createFromClient($loop, $asyncClient->reveal());

        $result = $client->sshKey($sshKeyId);

        self::assertSame($sshKey, $result);
    }

    public function provideObservableMethods()
    {
        yield [
            'hooks',
            HookInterface::class,
            random_int(13, 65),
        ];

        yield [
            'accounts',
            AccountInterface::class,
            random_int(13, 65),
        ];

        yield [
            'broadcasts',
            BroadcastInterface::class,
            random_int(13, 65),
        ];
    }

    /**
     * @dataProvider provideObservableMethods
     */
    public function testObservableMethods(string $method, string $resourceInterface, int $resourceCount)
    {
        $resources = iterator_to_array($this->generateResources($resourceInterface, $resourceCount));

        $loop = Factory::create();
        $asyncClient = $this->prophesize(AsyncClientInterface::class);
        $asyncClient->$method()->shouldBeCalled()->willReturn(Observable::fromArray($resources, new ImmediateScheduler()));

        $client = Client::createFromClient($loop, $asyncClient->reveal());

        $result = $client->$method();

        self::assertSame($resources, $result);
    }

    public function testRepositories()
    {
        $resources = iterator_to_array($this->generateResources(RepositoryInterface::class, random_int(13, 65)));

        $loop = Factory::create();
        $asyncClient = $this->prophesize(AsyncClientInterface::class);
        $asyncClient->repositories(null)->shouldBeCalled()->willReturn(Observable::fromArray($resources, new ImmediateScheduler()));

        $client = Client::createFromClient($loop, $asyncClient->reveal());

        $result = $client->repositories();

        self::assertSame($resources, $result);
    }

    public function testRepositoriesFilter()
    {
        $func = function () {
            return true;
        };

        $resources = iterator_to_array($this->generateResources(RepositoryInterface::class, random_int(13, 65)));

        $loop = Factory::create();
        $asyncClient = $this->prophesize(AsyncClientInterface::class);
        $asyncClient->repositories($func)->shouldBeCalled()->willReturn(Observable::fromArray($resources, new ImmediateScheduler()));

        $client = Client::createFromClient($loop, $asyncClient->reveal());

        $result = $client->repositories($func);

        self::assertSame($resources, $result);
    }

    private function generateResources(string $class, int $count): \Generator
    {
        for ($i = 0; $i < $count; $i++) {
            yield $this->prophesize($class)->reveal();
        }
    }
}
