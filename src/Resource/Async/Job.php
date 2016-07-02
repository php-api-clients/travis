<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Job as BaseJob;

class Job extends BaseJob
{
    /**
     * @return ObservableInterface
     */
    public function annotations(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('jobs/' . $this->id() . '/annotations')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['annotations']);
        })->map(function ($annotation) {
            return $this->getTransport()->getHydrator()->hydrate('Annotation', $annotation);
        });
    }
}
