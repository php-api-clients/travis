<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\EventLoop\LoopInterface;
use Rx\Observable;
use Rx\React\Promise;
use ApiClients\Foundation\Transport\Client as Transport;
use ApiClients\Foundation\Transport\Factory;
use ApiClients\Pusher\AsyncClient as PusherAsyncClient;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\ApiClient\Transport\Client as Transport;
use WyriHaximus\ApiClient\Transport\Factory;
use function React\Promise\resolve;

class AsyncClient
{
    /**
     * @var Transport
     */
    protected $transport;

    /**
     * @param LoopInterface $loop
     * @param string $token
     * @param Transport|null $transport
     */
    public function __construct(LoopInterface $loop, string $token = '', Transport $transport = null)
    {
        if (!($transport instanceof Transport)) {
            $pusher = new PusherAsyncClient($loop, ApiSettings::PUSHER_KEY);
            $transport = Factory::create($loop, [
            $options = [
                'resource_namespace' => 'Async',
                'setters' => [
                    'setPusher' => $pusher,
                ],
            ] + ApiSettings::TRANSPORT_OPTIONS);
            ] + ApiSettings::TRANSPORT_OPTIONS;

            if ($token !== '') {
                $options['headers']['Authorization'] = 'token ' . $token;
            }

            $transport = Factory::create($loop, $options);
        }
        $this->transport = $transport;
    }

    public function repository(string $repository): Observable
    /**
     * @param string $repository
     * @return PromiseInterface
     */
    public function repository(string $repository): PromiseInterface
    {
        return Promise::toObservable($this->transport->request('repos/' . $repository))
            ->map(function ($json) {
                return $this->transport->getHydrator()->hydrate('Repository', $json['repo']);
            });
    }

    /**
     * @return PromiseInterface
     */
    public function user(): PromiseInterface
    {
        return $this->transport->request('users')->then(function ($json) {
            return resolve($this->transport->getHydrator()->hydrate('User', $json['user']));
        });
    }

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function sshKey(int $id): PromiseInterface
    {
        return $this->transport->request('settings/ssh_key/' . $id)->then(function ($json) {
            return resolve($this->transport->getHydrator()->hydrate('SSHKey', $json['ssh_key']));
        });
    }

    /**
     * @return ObservableInterface
     */
    public function hooks(): ObservableInterface
    {
        return Promise::toObservable(
            $this->transport->request('hooks')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['hooks']);
        })->map(function ($hook) {
            return $this->transport->getHydrator()->hydrate('Hook', $hook);
        });
    }

    /**
     * @return ObservableInterface
     */
    public function accounts(): ObservableInterface
    {
        return Promise::toObservable(
            $this->transport->request('accounts')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['accounts']);
        })->map(function ($account) {
            return $this->transport->getHydrator()->hydrate('Account', $account);
        });
    }

    /**
     * @return ObservableInterface
     */
    public function broadcasts(): ObservableInterface
    {
        return Promise::toObservable(
            $this->transport->request('broadcasts')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['broadcasts']);
        })->map(function ($broadcast) {
            return $this->getTransport()->getHydrator()->hydrate('Broadcast', $broadcast);
        });
    }
}
