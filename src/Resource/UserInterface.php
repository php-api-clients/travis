<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use DateTimeInterface;
use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface UserInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return string
     */
    public function name() : string;

    /**
     * @return string
     */
    public function login() : string;

    /**
     * @return string
     */
    public function email() : string;

    /**
     * @return string
     */
    public function gravatarId() : string;

    /**
     * @return bool
     */
    public function isSyncing() : bool;

    /**
     * @return DateTimeInterface
     */
    public function syncedAt() : DateTimeInterface;

    /**
     * @return bool
     */
    public function correctScopes() : bool;

    /**
     * @return DateTimeInterface
     */
    public function createdAt() : DateTimeInterface;

    public function sync();
}
