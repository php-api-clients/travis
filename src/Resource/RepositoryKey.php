<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotations\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;

/**
 * @EmptyResource("EmptyRepositoryKey")
 */
abstract class RepositoryKey extends AbstractResource implements RepositoryKeyInterface
{
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
