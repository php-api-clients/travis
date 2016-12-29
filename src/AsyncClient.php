<?php declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Client\Travis\CommandBus\Command;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Foundation\ClientInterface;
use ApiClients\Foundation\Factory;
use React\EventLoop\LoopInterface;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\resolve;

final class AsyncClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param LoopInterface $loop
     * @param string $token
     * @param array $options
     * @return AsyncClient
     */
    public static function create(
        LoopInterface $loop,
        string $token = '',
        array $options = []
    ): self {
        $options = ApiSettings::getOptions($token, 'Async', $options);
        $client = Factory::create($loop, $options);
        return new self($client);
    }

    /**
     * @param ClientInterface $client
     * @return AsyncClient
     */
    public static function createFromClient(ClientInterface $client): self
    {
        return new self($client);
    }

    /**
     * @param ClientInterface $client
     */
    private function __construct(ClientInterface $client)
    {
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
        return $this->hooks()->filter(function ($hook) {
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
