<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Transport;

use DateTime;
use Phake;
use WyriHaximus\Tests\Travis\TestCase;
use WyriHaximus\Travis\Resource\Async\Repository as AsyncRepository;
use WyriHaximus\Travis\Resource\Sync\Repository as SyncRepository;
use WyriHaximus\Travis\Transport\Client;
use WyriHaximus\Travis\Transport\Hydrator;

class HydratorTest extends TestCase
{
    public function testBuildAsyncFromSync()
    {
        $hydrator = new Hydrator(Phake::mock(Client::class), []);
        $started_at = new DateTime();
        $finished_at = new DateTime();
        $syncRepository = $this->hydrate(
            SyncRepository::class,
            [
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
            ],
            'Async'
        );
        $asyncRepository = $hydrator->buildAsyncFromSync('Repository', $syncRepository);
        $this->assertInstanceOf(AsyncRepository::class, $asyncRepository);
        $this->assertSame(1, $asyncRepository->id());
        $this->assertSame('Wyrihaximus/php-travis-client', $asyncRepository->slug());
        $this->assertSame('(A)Sync PHP Travis client', $asyncRepository->description());
        $this->assertSame(2, $asyncRepository->lastBuildId());
        $this->assertSame(3, $asyncRepository->lastBuildNumber());
        $this->assertSame('complete', $asyncRepository->lastBuildState());
        $this->assertSame(456, $asyncRepository->lastBuildDuration());
        $this->assertSame($started_at, $asyncRepository->lastBuildStartedAt());
        $this->assertSame($finished_at, $asyncRepository->lastBuildFinishedAt());
        $this->assertSame('php', $asyncRepository->githubLanguage());
    }
}
