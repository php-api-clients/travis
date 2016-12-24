<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Client\Travis\CommandBus\Command;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Foundation\Client;
use ApiClients\Foundation\Factory;
use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\EventLoop\LoopInterface;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\resolve;
use Rx\React\Promise;

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
     * @return ObservableInterface
     */
    public function repositories(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->client->handle(
            new Command\HooksCommand()
        ))->filter(function (HookInterface $hook) {
            return $hook->active();
        })->flatMap(function (HookInterface $hook) {
            return Promise::toObservable($this->client->handle(
                new Command\RepositoryIdCommand($hook->id())
            ));
        });
    }

    /**
     * @return PromiseInterface
     */
    public function user(): PromiseInterface
    {
        return $this->client->handle(new Command\UserCommand());
    }

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function sshKey(int $id): PromiseInterface
    {
        return $this->client->handle(new Command\SSHKeyCommand($id));
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
