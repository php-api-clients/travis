<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Build as BaseBuild;
use function Clue\React\Block\await;

class Build extends BaseBuild
{
    public function jobs(): array
    {
        return await(
            Promise::fromObservable(
                $this->getTransport()->getHydrator()->buildAsyncFromSync('Build', $this)->jobs()->toArray()
            ),
            $this->getTransport()->getLoop()
        );
    }

    public function job(int $id): Job
    {
        return await(
            $this->getTransport()->getHydrator()->buildAsyncFromSync('Build', $this)->job($id),
            $this->getTransport()->getLoop()
        );
    }
}
