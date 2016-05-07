<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource;

use DateTime;
use DateTimeInterface;
use Generator;
use WyriHaximus\Travis\Resource\RepositoryInterface;

abstract class RepositoryTest extends AbstractResourceTest
{
    public function hydrateProvider(): Generator
    {
        $started_at = new DateTime();
        $finished_at = new DateTime();
        $json = [
            'id' => 1,
            'slug' => 'Wyrihaximus/php-travis-client',
            'description' => '(A)Sync PHP Travis client',
            'last_build_id' => 2,
            'last_build_number' => 3,
            'last_build_state' => 'complete',
            'last_build_duration' => 456,
            'last_build_started_at' => $started_at,
            'last_build_finished_at' => $finished_at,
            'github_language' => 'php',
        ];

        yield [
            $json,
            1,
            'id',
            'int',
        ];

        yield [
            $json,
            'Wyrihaximus/php-travis-client',
            'slug',
            'string',
        ];

        yield [
            $json,
            '(A)Sync PHP Travis client',
            'description',
            'string',
        ];

        yield [
            $json,
            2,
            'lastBuildId',
            'int',
        ];

        yield [
            $json,
            3,
            'lastBuildNumber',
            'int',
        ];

        yield [
            $json,
            'complete',
            'lastBuildState',
            'string',
        ];

        yield [
            $json,
            456,
            'lastBuildDuration',
            'int',
        ];

        yield [
            $json,
            $started_at,
            'lastBuildStartedAt',
            DateTimeInterface::class,
        ];

        yield [
            $json,
            $finished_at,
            'lastBuildFinishedAt',
            DateTimeInterface::class,
        ];

        yield [
            $json,
            'php',
            'githubLanguage',
            'string',
        ];
    }

    public function getClass(): string
    {
        return 'Repository';
    }

    public function testImplementsRepositoryInterface()
    {
        $this->assertInstanceOf(RepositoryInterface::class, $this->getRepository());
    }
}
