<?php

namespace WyriHaximus\Tests\Travis\Resource;

use WyriHaximus\Travis\Resource\Build;
use WyriHaximus\Travis\Resource\BuildInterface;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsBuildInterface()
    {
        $build = new Build();

        $this->assertInstanceOf(BuildInterface::class, $build);
    }
}
