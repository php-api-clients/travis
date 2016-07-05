<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface CacheInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function repositoryId() : int;

    /**
     * @return int
     */
    public function size() : int;

    /**
     * @return string
     */
    public function slug() : string;

    /**
     * @return string
     */
    public function branch() : string;

    /**
     * @return DateTimeInterface
     */
    public function lastModified() : DateTimeInterface;
}
