<?php

namespace WyriHaximus\Tests\Travis\Resource;

use WyriHaximus\Travis\Resource\Repository;
use WyriHaximus\Travis\Resource\RepositoryInterface;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsRepositoryInterface()
    {
        $repository = new Repository();

        $this->assertInstanceOf(RepositoryInterface::class, $repository);
    }
}
