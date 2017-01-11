<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Foundation\Factory;
use React\EventLoop\Factory as LoopFactory;
use React\EventLoop\LoopInterface;
use Rx\React\Promise;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
use ApiClients\Client\Travis\Resource\UserInterface;
use function Clue\React\Block\await;
use function React\Promise\resolve;

final class Client implements ClientInterface
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var AsyncClientInterface
     */
    private $asyncClient;

    /**
     * Create a new AsyncClient based on the loop and other options pass
     *
     * @param string $token Instructions to fetch the token: https://blog.travis-ci.com/2013-01-28-token-token-token/
     * @param array $options
     * @return Client
     */
    public static function create(
        string $token = '',
        array $options = []
    ): self {
        $loop = LoopFactory::create();
        $options = ApiSettings::getOptions($token, 'Sync', $options);
        $client = Factory::create($loop, $options);
        $asyncClient = AsyncClient::createFromClient($client);
        return self::createFromClient($loop, $asyncClient);
    }

    /**
     * Create an Client from a AsyncClientInterface.
     * Be sure to pass in a client with the options from ApiSettings and the Sync namespace suffix,
     * and pass in the same loop as associated with the AsyncClient you're passing in.
     *
     * @param LoopInterface $loop
     * @param AsyncClientInterface $asyncClient
     * @return Client
     */
    public static function createFromClient(LoopInterface $loop, AsyncClientInterface $asyncClient): self
    {
        return new self($loop, $asyncClient);
    }

    /**
     * @param LoopInterface $loop
     * @param AsyncClientInterface $asyncClient
     */
    private function __construct(LoopInterface $loop, AsyncClientInterface $asyncClient)
    {
        $this->loop = $loop;
        $this->asyncClient = $asyncClient;
    }

    /**
     * {@inheritdoc}
     */
    public function repository(string $repository): RepositoryInterface
    {
        return await(
            $this->asyncClient->repository($repository),
            $this->loop
        );
    }

    /**
     * {@inheritdoc}
     */
    public function user(): UserInterface
    {
        return await(
            $this->asyncClient->user(),
            $this->loop
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sshKey(int $id): SSHKeyInterface
    {
        return await(
            $this->asyncClient->sshKey($id),
            $this->loop
        );
    }

    /**
     * {@inheritdoc}
     */
    public function hooks(): array
    {
        return await(
            Promise::fromObservable(
                $this->asyncClient->hooks()->toArray()
            ),
            $this->loop
        );
    }

    /**
     * Warning this a intensive operation as it has to make a call for each hook
     * to turn it into a Repository!!!
     *
     * Take a look at examples/repositories-async.php on how to limit the amount of
     * concurrent requests.
     *
     * {@inheritdoc}
     */
    public function repositories(callable $filter = null): array
    {
        return await(
            Promise::fromObservable(
                $this->asyncClient->repositories($filter)->toArray()
            ),
            $this->loop
        );
    }

    /**
     * {@inheritdoc}
     */
    public function accounts(): array
    {
        return await(
            Promise::fromObservable(
                $this->asyncClient->accounts()->toArray()
            ),
            $this->loop
        );
    }

    /**
     * {@inheritdoc}
     */
    public function broadcasts(): array
    {
        return await(
            Promise::fromObservable(
                $this->asyncClient->broadcasts()->toArray()
            ),
            $this->loop
        );
    }
}
