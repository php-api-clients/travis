<?php declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Client\Travis\CommandBus\Command;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Foundation\ClientInterface;
use ApiClients\Foundation\Factory;
use React\EventLoop\LoopInterface;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;
use Rx\ObservableInterface;
use Rx\React\Promise;
use Rx\Scheduler;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;

final class AsyncClient implements AsyncClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Create a new AsyncClient based on the loop and other options pass
     *
     * @param LoopInterface $loop
     * @param string $token Instructions to fetch the token: https://blog.travis-ci.com/2013-01-28-token-token-token/
     * @param array $options
     * @return AsyncClient
     */
    public static function create(
        LoopInterface $loop,
        string $token = '',
        array $options = []
    ): self {
        try {
            Scheduler::setAsyncFactory(function () use ($loop) {
                return new Scheduler\EventLoopScheduler($loop);
            });
        } catch (\Throwable $t) {
        }

        $options = ApiSettings::getOptions($token, 'Async', $options);
        $client = Factory::create($loop, $options);
        return new self($client);
    }

    /**
     * Create an AsyncClient from a ApiClients\Foundation\ClientInterface.
     * Be sure to pass in a client with the options from ApiSettings and the Async namespace suffix.
     *
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
     * {@inheritdoc}
     */
    public function repository(string $repository): CancellablePromiseInterface
    {
        return $this->client->handle(new Command\RepositoryCommand($repository));
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
    public function repositories(callable $filter = null): ObservableInterface
    {
        if ($filter === null) {
            $filter = function () {
                return true;
            };
        }

        return $this->hooks()->filter(function ($hook) {
            return $hook->active();
        })->filter($filter)->flatMap(function (HookInterface $hook) {
            return Promise::toObservable($this->client->handle(
                new Command\RepositoryIdCommand($hook->id())
            ));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function user(): PromiseInterface
    {
        return $this->client->handle(new Command\UserCommand());
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function accounts(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->client->handle(
            new Command\AccountsCommand()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function broadcasts(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->client->handle(
            new Command\BroadcastsCommand()
        ));
    }
}
