<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\Repository as BaseRepository;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Client\Travis\Resource\RepositoryKeyInterface;
use ApiClients\Client\Travis\Resource\SettingsInterface;
use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use Rx\React\Promise;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    /**
     * @return array
     */
    public function builds(): array
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return Promise::fromObservable($repository->builds()->toArray());
            })
        );
    }

    /**
     * @param  int   $id
     * @return Build
     */
    public function build(int $id): Build
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) use ($id) {
                return $repository->build($id);
            })
        );
    }

    /**
     * @return array
     */
    public function commits(): array
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return Promise::fromObservable($repository->commits()->toArray());
            })
        );
    }

    /**
     * @return SettingsInterface
     */
    public function settings(): SettingsInterface
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return $repository->settings();
            })
        );
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return $repository->isActive();
            })->otherwise(function (bool $state) {
                return resolve($state);
            })
        );
    }

    /**
     * @return Repository
     */
    public function enable(): Repository
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return $repository->enable();
            })
        );
    }

    /**
     * @return Repository
     */
    public function disable(): Repository
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return $repository->disable();
            })
        );
    }

    /**
     * @return array
     */
    public function branches(): array
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return Promise::fromObservable($repository->branches()->toArray());
            })
        );
    }

    /**
     * @return array
     */
    public function vars(): array
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return Promise::fromObservable($repository->vars()->toArray());
            })
        );
    }

    /**
     * @return array
     */
    public function caches(): array
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return Promise::fromObservable($repository->caches()->toArray());
            })
        );
    }

    /**
     * @return RepositoryKeyInterface
     */
    public function key(): RepositoryKeyInterface
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return $repository->key();
            })
        );
    }

    /**
     * @return Repository
     */
    public function refresh(): Repository
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (RepositoryInterface $repository) {
                return $repository->refresh();
            })
        );
    }
}
