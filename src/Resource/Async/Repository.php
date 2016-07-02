<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function React\Promise\reject;
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

    public function isActive(): PromiseInterface
    {
        return $this->getTransport()->request(
            'hooks'
        )->then(function ($response) {
            $active = false;
            foreach ($response['hooks'] as $hook) {
                if ($hook['id'] == $this->id()) {
                    $active = (bool)$hook['active'];
                    break;
                }
            }

            if ($active) {
                return resolve($active);
            }

            return reject($active);
        });
    }
}
