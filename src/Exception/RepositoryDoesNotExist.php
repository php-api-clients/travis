<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Exception;

use Exception;

final class RepositoryDoesNotExist extends Exception
{
    /**
     * @var string
     */
    private $repository;

    public static function create(string $repository)
    {
        $exception = new self('Repository "' . $repository . '" does not exist');
        $exception->repository = $repository;

        return $exception;
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {
        return $this->repository;
    }
}
