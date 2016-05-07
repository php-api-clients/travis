<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource\Sync;

use WyriHaximus\Tests\Travis\Resource\BuildTest as BaseBuildTest;
use WyriHaximus\Travis\Resource\Sync\Build;

class BuildTest extends BaseBuildTest
{
    public function getNamespace(): string
    {
        return 'Sync\\';
    }

    public function getBuild()
    {
        return new Build();
    }
}
