<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use GuzzleHttp\Psr7\Request;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function React\Promise\reject;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    /**
     * @return ObservableInterface
     */
    public function builds(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['builds']);
        })->map(function ($build) {
            return $this->getTransport()->getHydrator()->hydrate('Build', $build);
        });
    }

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function build(int $id): PromiseInterface
    {
        return $this->getTransport()->request(
            'repos/' . $this->slug() . '/builds/' . $id
        )->then(function ($response) {
            return resolve($this->getTransport()->getHydrator()->hydrate('Build', $response['build']));
        });
    }

    /**
     * @return ObservableInterface
     */
    public function commits(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['commits']);
        })->map(function ($build) {
            return $this->getTransport()->getHydrator()->hydrate('Commit', $build);
        });
    }

    /**
     * @return PromiseInterface
     */
    public function settings(): PromiseInterface
    {
        return $this->getTransport()->request(
            'repos/' . $this->id() . '/settings'
        )->then(function ($response) {
            return resolve($this->getTransport()->getHydrator()->hydrate('Settings', $response['settings']));
        });
    }

    /**
     * @return PromiseInterface
     */
    public function isActive(): PromiseInterface
    {
        return $this->getTransport()->request(
            'hooks'
        )->then(function ($response) {
            $active = false;
            foreach ($response['hooks'] as $hook) {
                if ($hook['id'] == $this->id()) {
                    $active = (bool)$hook['active'];
                    break;
                }
            }

            if ($active) {
                return resolve($active);
            }

            return reject($active);
        });
    }

    /**
     * @return PromiseInterface
     */
    public function enable(): PromiseInterface
    {
        return $this->setActiveStatus(true);
    }

    /**
     * @return PromiseInterface
     */
    public function disable(): PromiseInterface
    {
        return $this->setActiveStatus(false);
    }

    /**
     * @param bool $status
     * @return PromiseInterface
     */
    protected function setActiveStatus(bool $status)
    {
        return $this->getTransport()->requestPsr7(
            new Request(
                'PUT',
                $this->getTransport()->getBaseURL() . 'hooks/' . $this->id(),
                $this->getTransport()->getHeaders(),
                json_encode([
                    'hook' => [
                        'active' => $status,
                    ],
                ])
            )
        );
    }

    /**
     * @return ObservableInterface
     */
    public function branches(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/branches')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['branches']);
        })->map(function ($branch) {
            return $this->getTransport()->getHydrator()->hydrate('Branch', $branch);
        });
    }

    public function vars(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('/settings/env_vars?repository_id=' . $this->id())
        )->flatMap(function ($response) {
            return Observable::fromArray($response['env_vars']);
        })->map(function ($var) {
            return $this->getTransport()->getHydrator()->hydrate('EnvironmentVariable', $var);
        });
    }

    public function caches(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/caches')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['caches']);
        })->map(function ($cache) {
            return $this->getTransport()->getHydrator()->hydrate('Cache', $cache);
        });
    }

    public function key(): PromiseInterface
    {
        return $this->getTransport()->request('repos/' . $this->slug() . '/key')->then(function ($key) {
            return resolve($this->getTransport()->getHydrator()->hydrate('RepositoryKey', $key));
        });
    }
}
