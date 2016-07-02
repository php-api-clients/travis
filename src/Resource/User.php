<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\TransportAwareTrait;

abstract class User implements UserInterface
{
    use TransportAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $gravatar_id;

    /**
     * @var bool
     */
    protected $is_syncing;

    /**
     * @var DateTimeInterface
     */
    protected $synced_at;

    /**
     * @var bool
     */
    protected $correct_scopes;

    /**
     * @var DateTimeInterface
     */
    protected $created_at;

    /**
     * @return int
     */
    public function id() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function login() : string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function email() : string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function gravatarId() : string
    {
        return $this->gravatar_id;
    }

    /**
     * @return bool
     */
    public function isSyncing() : bool
    {
        return $this->is_syncing;
    }

    /**
     * @return DateTimeInterface
     */
    public function syncedAt() : DateTimeInterface
    {
        return $this->synced_at;
    }

    /**
     * @return bool
     */
    public function correctScopes() : bool
    {
        return $this->correct_scopes;
    }

    /**
     * @return DateTimeInterface
     */
    public function createdAt() : DateTimeInterface
    {
        return $this->created_at;
    }
}
