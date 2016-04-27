<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use Rx\Observable;
use Rx\ObservableInterface;
use Rx\ObserverInterface;
use WyriHaximus\Travis\Resource\Async\Build;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    public function builds(): ObservableInterface
    {
        return Observable::create(function (ObserverInterface $observer) {
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')->then(function ($response) use ($observer) {
                foreach ($response['builds'] as $build) {
                    $observer->onNext($this->getTransport()->hydrate(Build::class, $build));
                }
            });
        });
    }
}
