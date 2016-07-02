<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

use React\EventLoop\LoopInterface;
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
            $options = [
                'resource_namespace' => 'Async',
            ] + ApiSettings::TRANSPORT_OPTIONS;

            if ($token !== '') {
                $options['headers']['Authorization'] = 'token ' . $token;
            }

            $transport = Factory::create($loop, $options);
        }
        $this->transport = $transport;
    }

    public function repository(string $repository): PromiseInterface
    {
        return $this->transport->request('repos/' . $repository)->then(function ($json) {
            return resolve($this->transport->getHydrator()->hydrate('Repository', $json['repo']));
        });
    }

    public function user(): PromiseInterface
    {
        return $this->transport->request('users')->then(function ($json) {
            return resolve($this->transport->getHydrator()->hydrate('User', $json['user']));
        });
    }

    public function sshKey(int $id): PromiseInterface
    {
        return $this->transport->request('settings/ssh_key/' . $id)->then(function ($json) {
            return resolve($this->transport->getHydrator()->hydrate('SSHKey', $json['ssh_key']));
        });
    }

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
