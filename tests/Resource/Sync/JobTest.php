<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource\Sync;

use WyriHaximus\Tests\Travis\Resource\JobTest as BaseJobTest;
use WyriHaximus\Travis\Resource\Sync\Job;

class JobTest extends BaseJobTest
{
    public function getNamespace(): string
    {
        return 'Sync\\';
    }

    public function getJob()
    {
        return new Job();
    }
}
