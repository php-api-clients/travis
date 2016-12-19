<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Client\Travis\CommandBus\Command;
use ApiClients\Foundation\Client;
use ApiClients\Foundation\Factory;
use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\EventLoop\LoopInterface;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\resolve;

class AsyncClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param LoopInterface $loop
     * @param string $token
     * @param Client|null $client
     */
    public function __construct(LoopInterface $loop, string $token = '', Client $client = null)
    {
        if (!($client instanceof Client)) {
            $this->options = ApiSettings::getOptions($token, 'Async');
            $client = Factory::create($loop, $this->options);
        }
        $this->client = $client;
    }

    /**
     * @param string $repository
     * @return CancellablePromiseInterface
     */
    public function repository(string $repository): CancellablePromiseInterface
    {
        return $this->client->handle(new Command\RepositoryCommand($repository));
    }

    /**
     * @return PromiseInterface
     */
    public function user(): PromiseInterface
    {
        return $this->client->handle(new SimpleRequestCommand('users'))->then(function ($response) {
            return $this->client->handle(new HydrateCommand('User', $response->getBody()->getJson()['user']));
        });
    }

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function sshKey(int $id): PromiseInterface
    {
        return $this->client->handle(new SimpleRequestCommand('settings/ssh_key/' . $id))->then(function ($response) {
            return $this->client->handle(new HydrateCommand('SSHKey', $response->getBody()->getJson()['ssh_key']));
        });
    }

    /**
     * @return ObservableInterface
     */
    public function hooks(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->client->handle(
            new Command\HooksCommand()
        ));
    }

    /**
     * @return ObservableInterface
     */
    public function accounts(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->client->handle(
            new Command\AccountsCommand()
        ));
    }

    /**
     * @return ObservableInterface
     */
    public function broadcasts(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->client->handle(
            new Command\BroadcastsCommand()
        ));
    }
}
