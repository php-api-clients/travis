<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource\Sync;

use WyriHaximus\Tests\Travis\Resource\RepositoryTest as BaseRepositoryTest;
use WyriHaximus\Travis\Resource\Sync\Repository;

class RepositoryTest extends BaseRepositoryTest
{
    public function getNamespace(): string
    {
        return 'Sync\\';
    }

    public function getRepository()
    {
        return new Repository();
    }
}
