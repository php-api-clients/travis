<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource\Async;

use WyriHaximus\Tests\Travis\Resource\BuildTest as BaseBuildTest;
use WyriHaximus\Travis\Resource\Async\Build;

class BuildTest extends BaseBuildTest
{
    public function getNamespace(): string
    {
        return 'Async\\';
    }

    public function getBuild()
    {
        return new Build();
    }
}
