<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotation\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;
use DateTimeInterface;
use DateTimeImmutable;

/**
 * @EmptyResource("EmptyUser")
 */
abstract class User extends AbstractResource implements UserInterface
{
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
        return new DateTimeImmutable($this->synced_at);
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
        return new DateTimeImmutable($this->created_at);
    }
}
