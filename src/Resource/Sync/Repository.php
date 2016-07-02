<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\ApiClient\Resource\CallAsyncTrait;
use WyriHaximus\Travis\Resource\Repository as BaseRepository;
use function Clue\React\Block\await;
use function React\Promise\resolve;
use WyriHaximus\Travis\Resource\SettingsInterface;
use WyriHaximus\Travis\Resource\RepositoryKeyInterface;

class Repository extends BaseRepository
{
    use CallAsyncTrait;

    /**
     * @return array
     */
    public function builds(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('builds')->toArray()));
    }

    /**
     * @param int $id
     * @return Build
     */
    public function build(int $id): Build
    {
        return $this->wait($this->callAsync('build', $id));
    }

    /**
     * @return array
     */
    public function commits(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('commits')->toArray()));
    }

    /**
     * @return SettingsInterface
     */
    public function settings(): SettingsInterface
    {
        return $this->wait($this->callAsync('settings'));
    }

    public function isActive(): bool
    {
        return $this->wait($this->callAsync('isActive'));
    }

    public function enable(): Repository
    {
        return $this->wait($this->callAsync('enable'));
    }

    public function disable(): Repository
    {
        return $this->wait($this->callAsync('disable'));
    }

    public function branches(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('branches')->toArray()));
    }

    public function vars(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('vars')->toArray()));
    }

    public function caches(): array
    {
        return $this->wait($this->observableToPromise($this->callAsync('caches')->toArray()));
    }

    public function key(): RepositoryKeyInterface
    {
        return $this->wait($this->callAsync('key'));
    }
}
