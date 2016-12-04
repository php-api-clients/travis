<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotations\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;
use DateTimeInterface;

/**
 * @EmptyResource("EmptyCache")
 */
abstract class Cache extends AbstractResource implements CacheInterface
{
    /**
     * @var int
     */
    protected $repository_id;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $branch;

    /**
     * @var DateTimeInterface
     */
    protected $last_modified;

    /**
     * @return int
     */
    public function repositoryId() : int
    {
        return $this->repository_id;
    }

    /**
     * @return int
     */
    public function size() : int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function slug() : string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function branch() : string
    {
        return $this->branch;
    }

    /**
     * @return DateTimeInterface
     */
    public function lastModified() : DateTimeInterface
    {
        return $this->last_modified;
    }
}
