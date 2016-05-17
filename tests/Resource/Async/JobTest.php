<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource\Async;

use WyriHaximus\Tests\Travis\Resource\JobTest as BaseJobTest;
use WyriHaximus\Travis\Resource\Async\Job;

class JobTest extends BaseJobTest
{
    public function getNamespace(): string
    {
        return 'Async\\';
    }

    public function getJob()
    {
        return new Job();
    }
}
