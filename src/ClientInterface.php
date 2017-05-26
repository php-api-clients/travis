<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
use ApiClients\Client\Travis\Resource\UserInterface;

interface ClientInterface
{
    /**
     * Fetch the given repository.
     * This will return a Resource\Async\Repository object.
     *
     * @param  string              $repository
     * @return RepositoryInterface
     */
    public function repository(string $repository): RepositoryInterface;

    /**
     * This function accepts an optional callable passed into a filter call
     * on the hooks observable before it fetches the repository information.
     * It could be used to only fetch new repositories.
     *
     * @param  callable|null $filter
     * @return array
     */
    public function repositories(callable $filter = null): array;

    /**
     * Fetch information about the current authenticated user.
     * This will return a Resource\Sync\User object.
     * (Requires auth token to be passed to the client!).
     *
     * @return UserInterface
     */
    public function user(): UserInterface;

    /**
     * Fetch the SSH key for the given repository ID.
     * This will return a Resource\Sync\SSHKey object.
     * (Requires auth token to be passed to the client!)
     * (Only available on Travis Pro: https://travis-ci.com/).
     *
     * @param  int             $id
     * @return SSHKeyInterface
     */
    public function sshKey(int $id): SSHKeyInterface;

    /**
     * Fetch the list of available hooks.
     * Hooks represent whether a repository is active or not,
     * their ID's match that of the repository they represent.
     * This will return an array of Resource\Sync\Hook objects.
     * (Requires auth token to be passed to the client!).
     *
     * @return array
     */
    public function hooks(): array;

    /**
     * Fetch a stream of which users and orgs the currently authenticated user has access to.
     * This will return an array of Resource\Sync\Account objects.
     * (Requires auth token to be passed to the client!).
     *
     * @return array
     */
    public function accounts(): array;

    /**
     * Fetch a list of currently active broadcast. Used by the Travis team to spread news on the site.
     * This will return an array of Resource\Sync\Broadcast objects.
     * (Requires auth token to be passed to the client!).
     *
     * @return array
     */
    public function broadcasts(): array;
}
