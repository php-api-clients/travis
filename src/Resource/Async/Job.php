<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use React\Promise\PromiseInterface;
use Rx\ObservableInterface;
use WyriHaximus\Travis\Resource\Job as BaseJob;
use function React\Promise\resolve;

class Job extends BaseJob
{
    public function log(): ObservableInterface
    {
        return $this->getPusher()->channel('job-' . $this->id)->filter(function ($message) {
            return $message->event == 'job:log';
        })->map(function ($message) {
            return json_decode($message->data, true);
        })->map(function (array $json) {
            return $this->getTransport()->getHydrator()->hydrate('LogLine', $json);
        });
    }
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

    /**
     * @return PromiseInterface
     */
    public function refresh(): PromiseInterface
    {
        return $this->getTransport()->request('jobs/' . $this->id)->then(function ($json) {
            return resolve($this->getTransport()->getHydrator()->hydrate('Job', $json['job']));
        });
    }
}
