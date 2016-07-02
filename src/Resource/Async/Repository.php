<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    public function builds(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['builds']);
        })->map(function ($build) {
            return $this->getTransport()->getHydrator()->hydrate('Build', $build);
        });
    }

    public function build(int $id): PromiseInterface
    {
        return $this->getTransport()->request(
            'repos/' . $this->slug() . '/builds/' . $id
        )->then(function ($response) {
            return resolve($this->getTransport()->getHydrator()->hydrate('Build', $response['build']));
        });
    }

    public function commits(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['commits']);
        })->map(function ($build) {
            return $this->getTransport()->getHydrator()->hydrate('Commit', $build);
        });
    }

    public function branches(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/branches')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['branches']);
        })->map(function ($branch) {
            return $this->getTransport()->getHydrator()->hydrate('Branch', $branch);
        });
    }
}
