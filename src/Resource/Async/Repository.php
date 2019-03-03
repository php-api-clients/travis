<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command;
use ApiClients\Client\Travis\Resource\HookInterface;
use ApiClients\Client\Travis\Resource\Repository as BaseRepository;
use ApiClients\Foundation\Transport\CommandBus\Command\RequestCommand;
use ApiClients\Middleware\Json\JsonStream;
use GuzzleHttp\Psr7\Request;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
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
     * @param  int                         $id
     * @return CancellablePromiseInterface
     */
    public function build(int $id): CancellablePromiseInterface
    {
        return $this->handleCommand(new Command\BuildCommand($id));
    }

    /**
     * @return Observable
     */
    public function commits(): Observable
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
            return resolve($hook->active());
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
     * @return Observable
     */
    public function branches(): Observable
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new Command\BranchesCommand($this->id())
        ));
    }

    /**
     * @return Observable
     */
    public function vars(): Observable
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new Command\VarsCommand($this->id())
        ));
    }

    /**
     * @return Observable
     */
    public function caches(): Observable
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

    /**
     * @param  bool             $status
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
}
