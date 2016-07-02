<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Build as BaseBuild;
use function React\Promise\resolve;

class Build extends BaseBuild
{
    /**
     * @return ObservableInterface
     */
    public function jobs(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('builds/' . $this->id())
        )->flatMap(function ($response) {
            return Observable::fromArray($response['jobs']);
        })->map(function ($job) {
            return $this->getTransport()->getHydrator()->hydrate('Job', $job);
        });
    }

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function job(int $id): PromiseInterface
    {
        return $this->getTransport()->request(
            'jobs/' . $id
        )->then(function ($response) {
            return resolve($this->getTransport()->getHydrator()->hydrate('Job', $response['job']));
        });
    }
}
