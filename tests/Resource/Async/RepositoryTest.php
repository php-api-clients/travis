<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource\Async;

use WyriHaximus\Tests\Travis\Resource\RepositoryTest as BaseRepositoryTest;
use WyriHaximus\Travis\Resource\Async\Repository;

class RepositoryTest extends BaseRepositoryTest
{
    public function getNamespace(): string
    {
        return 'Async\\';
    }

    public function getRepository()
    {
        return new Repository();
    }
}
