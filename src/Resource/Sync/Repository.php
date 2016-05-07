<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use Rx\Observable;
use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function Clue\React\Block\await;
use function React\Promise\resolve;

class Repository extends BaseRepository
{
    public function builds(): array
    {
        return await(
            Promise::fromObservable(
                $this->getTransport()->buildAsyncFromSync('Repository', $this)->builds()->toArray()
            ),
            $this->getTransport()->getLoop()
        );
    }

    public function build(int $id): Build
    {
        return await(
            $this->getTransport()->buildAsyncFromSync('Repository', $this)->build($id),
            $this->getTransport()->getLoop()
        );
    }
}
