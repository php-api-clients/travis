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
     * @param string $token
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
     * @param LoopInterface $loop
     * @param AsyncClientInterface $asyncClient
     * @return Client
     */
    public static function createFromClient(LoopInterface $loop, AsyncClientInterface $asyncClient): self
    {
        return new self($loop, $asyncClient);
    }

    /**
     * Client constructor.
     * @param LoopInterface $loop
     * @param AsyncClientInterface $asyncClient
     */
    private function __construct(LoopInterface $loop, AsyncClientInterface $asyncClient)
    {
        $this->loop = $loop;
        $this->asyncClient = $asyncClient;
    }

    /**
     * @param string $repository
     * @return RepositoryInterface
     */
    public function repository(string $repository): RepositoryInterface
    {
        return await(
            $this->asyncClient->repository($repository),
            $this->loop
        );
    }

    /**
     * @return UserInterface
     */
    public function user(): UserInterface
    {
        return await(
            $this->asyncClient->user(),
            $this->loop
        );
    }

    /**
     * @param int $id
     * @return SSHKeyInterface
     */
    public function sshKey(int $id): SSHKeyInterface
    {
        return await(
            $this->asyncClient->sshKey($id),
            $this->loop
        );
    }

    /**
     * @return array
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
     * @return array
     */
    public function repositories(): array
    {
        return await(
            Promise::fromObservable(
                $this->asyncClient->repositories()->toArray()
            ),
            $this->loop
        );
    }

    /**
     * @return array
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
     * @return array
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
