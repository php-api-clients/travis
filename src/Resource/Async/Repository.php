<?php
declare(strict_types = 1);

namespace WyriHaximus\Travis\Resource\Async;

use Rx\Observable;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    public function builds(): Observable
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['builds']);
        })->map(function ($build) {
            return $this->getTransport()->getHydrator()->hydrate('Build', $build);
        });
    }

    public function build(int $id): Observable
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds/' . $id)
        )->map(function ($response) {
            return $this->getTransport()->getHydrator()->hydrate('Build', $response['build']);
        });
    }

    public function jobs(int $buildId): Observable
    {
        return $this->build($buildId)->flatMap(function (Build $build) {
            return $build->jobs();
        });
    }

    public function commits(): Observable
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['commits']);
        })->map(function ($build) {
            return $this->getTransport()->getHydrator()->hydrate('Commit', $build);
        });
    }

    public function events(): Observable
    {
        return $this->getPusher()->channel('repo-' . $this->id)->filter(function ($message) {
            return in_array($message->event, [
                'build:created',
                'build:started',
                'build:finished',
            ]);
        })->map(function ($message) {
            return json_decode($message->data, true);
        })->filter(function ($json) {
            return isset($json['repository']);
        })->map(function ($json) {
            return $this->getTransport()->getHydrator()->hydrate('Repository', $json['repository']);
        });
    }
}
