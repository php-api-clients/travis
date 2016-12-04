<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Job as BaseJob;
use WyriHaximus\Travis\Resource\JobInterface;

class Job extends BaseJob
{
    /**
     * @return array
     */
    public function annotations(): array
    {
        return $this->wait(
            $this->handleCommand(
                new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
            )->then(function (JobInterface $job) {
                return Promise::fromObservable($job->annotations());
            })
        );
    }

    public function refresh() : Job
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (JobInterface $job) {
            return $job->refresh();
        }));
    }
}
