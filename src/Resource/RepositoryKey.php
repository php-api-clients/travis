<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\TransportAwareTrait;

abstract class RepositoryKey implements RepositoryKeyInterface
{
    use TransportAwareTrait;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $fingerprint;

    /**
     * @return string
     */
    public function key() : string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function fingerprint() : string
    {
        return $this->fingerprint;
    }
}
