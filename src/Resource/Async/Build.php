<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use Rx\React\Promise;
use WyriHaximus\Travis\Resource\Build as BaseBuild;

class Build extends BaseBuild
{
    public function jobs(): ObservableInterface
    {
        return Promise::toObservable(
            $this->getTransport()->request('repos/' . $this->slug() . '/builds')
        )->flatMap(function ($response) {
            return Observable::fromArray($response['builds']);
        })->map(function ($build) {
            return $this->getTransport()->getHydrator()->hydrate('Build', $build);
        });
    }
}
