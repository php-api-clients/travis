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

class Client
{
    /**
     * @var LoopInterface
     */
    protected $loop;

    /**
     * @var AsyncClient
     */
    protected $client;

    /**
     * @param string $token
     */
    public function __construct(string $token = '')
    {
        $this->loop = LoopFactory::create();
        $this->options = ApiSettings::getOptions($token, 'Sync');
        $this->client = new AsyncClient($this->loop, $token, Factory::create($this->loop, $this->options));
    }

    /**
     * @param string $repository
     * @return RepositoryInterface
     */
    public function repository(string $repository): RepositoryInterface
    {
        return await(
            $this->client->repository($repository),
            $this->loop
        );
    }

    /**
     * @return UserInterface
     */
    public function user(): UserInterface
    {
        return await(
            $this->client->user(),
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
            $this->client->sshKey($id),
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
                $this->client->hooks()->toArray()
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
                $this->client->accounts()->toArray()
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
                $this->client->broadcasts()->toArray()
            ),
            $this->loop
        );
    }
}
