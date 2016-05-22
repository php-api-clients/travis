<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Build as BaseBuild;

class Build extends BaseBuild
{
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

    public function job(int $id): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('jobs/' . $id)
        )->map(function ($response) {
            return $this->getTransport()->getHydrator()->hydrate('Job', $response['job']);
        });
    }
}
