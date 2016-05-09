<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource;

use DateTime;
use DateTimeInterface;
use Generator;
use WyriHaximus\Travis\Resource\JobInterface;

abstract class JobTest extends AbstractResourceTest
{
    public function hydrateProvider(): Generator
    {
        $started_at = new DateTime();
        $finished_at = new DateTime();
        $json = [
            'id' => 1,
            'build_id' => 1,
            'repository_id' => 1,
            'commit_id' => 1,
            'log_id' => 1,
            'number' => '1.2',
            'config' => [
                'php' => 7.0,
                'lowest' => true,
            ],
            'state' => 'done',
            'started_at' => $started_at,
            'finished_at' => $finished_at,
            'queue' => 'queue',
            'allow_failure' => true,
            'annotation_ids'=> [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
            ],
        ];

        yield [
            $json,
            1,
            'id',
            'int',
        ];

        yield [
            $json,
            1,
            'repositoryId',
            'int',
        ];

        yield [
            $json,
            1,
            'commitId',
            'int',
        ];

        yield [
            $json,
            1,
            'logId',
            'int',
        ];

        yield [
            $json,
            '1.2',
            'number',
            'string',
        ];

        yield [
            $json,
            [
                'php' => 7.0,
                'lowest' => true,
            ],
            'config',
            'array',
        ];

        yield [
            $json,
            'done',
            'state',
            'string',
        ];

        yield [
            $json,
            $started_at,
            'startedAt',
            DateTimeInterface::class,
        ];

        yield [
            $json,
            $finished_at,
            'finishedAt',
            DateTimeInterface::class,
        ];

        yield [
            $json,
            'queue',
            'queue',
            'string',
        ];

        yield [
            $json,
            true,
            'allowFailure',
            'bool',
        ];

        yield [
            $json,
            [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
            ],
            'annotationIds',
            'array',
        ];
    }

    public function getClass(): string
    {
        return 'Job';
    }

    public function testImplementsJobInterface()
    {
        $this->assertInstanceOf(JobInterface::class, $this->getJob());
    }
}
