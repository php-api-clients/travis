<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use Rx\Observable;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Async\Repository as AsyncRepository;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function Clue\React\Block\await;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    public function builds()
    {
        return await(
            Promise::fromObservable(
                $this->getTransport()->hydrateFQCN(
                    AsyncRepository::class,
                    $this->getTransport()->extractFQCN(AsyncRepository::class, $this)
                )->builds()->toArray()
            ),
            $this->getTransport()->getLoop()
        );
    }
}
