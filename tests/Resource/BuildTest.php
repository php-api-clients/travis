<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource;

use DateTime;
use DateTimeInterface;
use Generator;
use WyriHaximus\Travis\Resource\BuildInterface;

abstract class BuildTest extends AbstractResourceTest
{
    public function hydrateProvider(): Generator
    {
        $started_at = new DateTime();
        $finished_at = new DateTime();
        $json = [
            'id' => 1,
            'repository_id' => 1,
            'commit_id' => 1,
            'number' => 2,
            'pull_request' => true,
            'pull_request_title' => '#1',
            'pull_request_number' => 1,
            'config' => [
                'php' => 7.0,
                'lowest' => true,
            ],
            'state' => 'done',
            'started_at' => $started_at,
            'finished_at' => $finished_at,
            'duration' => 345,
            'job_ids' => [
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
            2,
            'number',
            'int',
        ];

        yield [
            $json,
            true,
            'pullRequest',
            'bool',
        ];

        yield [
            $json,
            '#1',
            'pullRequestTitle',
            'string',
        ];

        yield [
            $json,
            1,
            'pullRequestNumber',
            'int',
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
            345,
            'duration',
            'int',
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
            'jobIds',
            'array',
        ];
    }

    public function getClass(): string
    {
        return 'Build';
    }

    public function testImplementsBuildInterface()
    {
        $this->assertInstanceOf(BuildInterface::class, $this->getBuild());
    }
}
