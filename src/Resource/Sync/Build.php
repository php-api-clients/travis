<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use Rx\React\Promise;
use ApiClients\Client\Travis\Resource\Build as BaseBuild;
use ApiClients\Client\Travis\Resource\BuildInterface;

class Build extends BaseBuild
{
    /**
     * @return array
     */
    public function jobs(): array
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (BuildInterface $build) {
                return Promise::fromObservable($build->jobs());
            })
        );
    }

    /**
     * @param int $id
     * @return Job
     */
    public function job(int $id): Job
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (BuildInterface $build) use ($id) {
                return $build->job($id);
            })
        );
    }

    /**
     * @return Build
     */
    public function refresh() : Build
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (BuildInterface $build) {
                return $build->refresh();
            })
        );
    }
}
