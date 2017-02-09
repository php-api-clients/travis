<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Pusher\CommandBus\Command\SharedAppClientCommand;
use ApiClients\Client\Pusher\Event;
use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\CommandBus\Command;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Client\Travis\Resource\Repository as BaseRepository;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\RequestCommand;
use ApiClients\Foundation\Transport\JsonStream;
use GuzzleHttp\Psr7\Request;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\Observer\CallbackObserver;
use Rx\ObserverInterface;
use Rx\React\Promise;
use Rx\SchedulerInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\reject;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    public function builds(): Observable
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new Command\BuildsCommand($this->slug())
        ));
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
        return $this->handleCommand(new Command\BuildCommand($id));
    }

    /**
     * @return ObservableInterface
     */
    public function commits(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new Command\CommitsCommand($this->slug())
        ));
    }

    /**
     * @return Observable
     */
    public function events(): Observable
    {
        return unwrapObservableFromPromise(
            $this->handleCommand(new Command\RepositoryEventsCommand($this->id()))
        );
    }

    /**
     * @return PromiseInterface
     */
    public function settings(): PromiseInterface
    {
        return $this->handleCommand(
            new Command\SettingsCommand($this->id())
        );
    }

    /**
     * @return PromiseInterface
     */
    public function isActive(): PromiseInterface
    {
        return Promise::fromObservable(unwrapObservableFromPromise($this->handleCommand(
            new Command\HooksCommand()
        ))->filter(function (HookInterface $hook) {
            return $this->id() === $hook->id();
        }))->then(function (HookInterface $hook) {
            $active = $hook->active();

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
        return unwrapObservableFromPromise($this->handleCommand(
            new Command\BranchesCommand($this->id())
        ));
    }

    /**
     * @return ObservableInterface
     */
    public function vars(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new Command\VarsCommand($this->id())
        ));
    }

    /**
     * @return ObservableInterface
     */
    public function caches(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new Command\CachesCommand($this->id())
        ));
    }

    /**
     * @return PromiseInterface
     */
    public function key(): PromiseInterface
    {
        return $this->handleCommand(
            new Command\RepositoryKeyCommand($this->slug())
        );
    }

    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(
            new Command\RepositoryCommand($this->slug)
        );
    }
}
