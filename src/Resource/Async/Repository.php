<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Pusher\AsyncClient;
use ApiClients\Client\Pusher\CommandBus\Command\SharedAppClientCommand;
use ApiClients\Client\Travis\CommandBus\Command\CachesCommand;
use ApiClients\Client\Travis\CommandBus\Command\RepositoryCommand;
use ApiClients\Client\Travis\CommandBus\Command\RepositoryKeyCommand;
use ApiClients\Client\Travis\CommandBus\Command\VarsCommand;
use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\RequestCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use ApiClients\Foundation\Transport\JsonStream;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\Observer\CallbackObserver;
use Rx\ObserverInterface;
use Rx\React\Promise;
use Rx\SchedulerInterface;
use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\Resource\Repository as BaseRepository;
use function React\Promise\reject;
use function React\Promise\resolve;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;

class Repository extends BaseRepository
{
    public function builds(): Observable
    {
        return Promise::toObservable(
            $this->handleCommand(new SimpleRequestCommand('repos/' . $this->slug() . '/builds'))
        )->flatMap(function (ResponseInterface $response) {
            return Observable::fromArray($response->getBody()->getJson()['builds']);
        })->flatMap(function (array $build) {
            return Promise::toObservable($this->handleCommand(new HydrateCommand('Build', $build)));
        });
    }

    public function jobs(int $buildId): Observable
    {
        return Promise::toObservable($this->build($buildId))->flatMap(function (Build $build) {
            return $build->jobs();
        });
    }

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function build(int $id): PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('repos/' . $this->slug() . '/builds/' . $id)
        )->then(function (ResponseInterface $response) {
            return resolve($this->handleCommand(
                new HydrateCommand('Build', $response->getBody()->getJson()['build'])
            ));
        });
    }

    /**
     * @return ObservableInterface
     */
    public function commits(): ObservableInterface
    {
        return Promise::toObservable(
            $this->handleCommand(new SimpleRequestCommand('repos/' . $this->slug() . '/builds'))
        )->flatMap(function (ResponseInterface $response) {
            return Observable::fromArray($response->getBody()->getJson()['commits']);
        })->flatMap(function (array $commit) {
            return Promise::toObservable($this->handleCommand(new HydrateCommand('Commit', $commit)));
        });
    }

    public function events(): Observable
    {
        return Observable::create(function (
            ObserverInterface $observer,
            SchedulerInterface $scheduler
        ) {
            $this->handleCommand(
                new SharedAppClientCommand(ApiSettings::PUSHER_KEY)
            )->then(function ($pusher) use ($observer) {
                $pusher->channel('repo-' . $this->id)->filter(function ($message) {
                    return in_array($message->event, [
                        'build:created',
                        'build:started',
                        'build:finished',
                    ]);
                })->map(function ($message) {
                    return json_decode($message->data, true);
                })->filter(function ($json) {
                    return isset($json['repository']);
                })->flatMap(function ($json) {
                    return Promise::toObservable(
                        $this->handleCommand(
                            new HydrateCommand('Repository', $json['repository'])
                        )
                    );
                })->subscribe(new CallbackObserver(function ($repository) use ($observer) {
                    $observer->onNext($repository);
                }));
            });
        });
    }

    /**
     * @return PromiseInterface
     */
    public function settings(): PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('repos/' . $this->id() . '/settings')
        )->then(function (ResponseInterface $response) {
            return resolve($this->handleCommand(
                new HydrateCommand('Settings', $response->getBody()->getJson()['settings'])
            ));
        });
    }

    /**
     * @return PromiseInterface
     */
    public function isActive(): PromiseInterface
    {
        return $this->handleCommand(new SimpleRequestCommand('hooks'))->then(function (ResponseInterface $response) {
            $active = false;
            foreach ($response->getBody()->getJson()['hooks'] as $hook) {
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
        return $this->handleCommand(new RequestCommand(
            new Request(
                'PUT',
                'hooks/' . $this->id(),
                [],
                new JsonStream([
                    'hook' => [
                        'active' => $status,
                    ],
                ])
            )
        ))->then(function () {
            return $this->refresh();
        });
    }

    /**
     * @return ObservableInterface
     */
    public function branches(): ObservableInterface
    {
        return Promise::toObservable(
            $this->handleCommand(new SimpleRequestCommand('repos/' . $this->slug() . '/branches'))
        )->flatMap(function (ResponseInterface $response) {
            return Observable::fromArray($response->getBody()->getJson()['branches']);
        })->flatMap(function (array $branch) {
            return Promise::toObservable($this->handleCommand(new HydrateCommand('Branch', $branch)));
        });
    }

    /**
     * @return ObservableInterface
     */
    public function vars(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new VarsCommand($this->id())
        ));
    }

    /**
     * @return ObservableInterface
     */
    public function caches(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new CachesCommand($this->slug())
        ));
    }

    /**
     * @return PromiseInterface
     */
    public function key(): PromiseInterface
    {
        return $this->handleCommand(
            new RepositoryKeyCommand($this->slug())
        );
    }

    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(
            new RepositoryCommand($this->slug)
        );
    }
}
