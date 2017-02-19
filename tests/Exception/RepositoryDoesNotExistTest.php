<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Exception;

use ApiClients\Client\Travis\Exception\RepositoryDoesNotExist;
use ApiClients\Tools\TestUtilities\TestCase;

final class RepositoryDoesNotExistTest extends TestCase
{
    public function testCreate()
    {
        $repository = 'php-api-clients/travis';

        $exception = RepositoryDoesNotExist::create($repository);

        self::assertSame('Repository "' . $repository . '" does not exist', $exception->getMessage());
        self::assertSame($repository, $exception->getRepository());
    }
}
