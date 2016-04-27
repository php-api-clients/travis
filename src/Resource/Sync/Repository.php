<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use Rx\Observable;
use Rx\ObservableInterface;
use Rx\ObserverInterface;
use WyriHaximus\Travis\Resource\Sync\Build;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function Clue\React\Block\await;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    public function builds()
    {
        return await(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')->then(function ($json) {
                $builds = [];
                foreach ($json['builds'] as $build) {
                    $builds[] = $this->getTransport()->hydrate(Build::class, $build);
                }
                return resolve($builds);
            }),
            $this->getTransport()->getLoop()
        );
    }
}
