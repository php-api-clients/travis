<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis;

use Phake;
use WyriHaximus\Travis\Transport\Client;
use WyriHaximus\Travis\Transport\Hydrator;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $tmpDir;

    public function setUp()
    {
        parent::setUp();
        $this->tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('wyrihaximus-php-travis-client-tests-') . DIRECTORY_SEPARATOR;
        mkdir($this->tmpDir, 0777, true);
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->rmdir($this->tmpDir);
    }

    protected function rmdir($dir)
    {
        $directory = dir($dir);
        while (false !== ($entry = $directory->read())) {
            if (in_array($entry, ['.', '..'])) {
                continue;
            }

            if (is_dir($dir . $entry)) {
                $this->rmdir($dir . $entry . DIRECTORY_SEPARATOR);
                continue;
            }

            if (is_file($dir . $entry)) {
                unlink($dir . $entry);
                continue;
            }
        }
        $directory->close();
        rmdir($dir);
    }

    protected function getTmpDir(): string
    {
        return $this->tmpDir;
    }

    public function hydrate($class, $json, $namespace)
    {
        return (new Hydrator(Phake::mock(Client::class), [
            'resource_namespace' => $namespace,
        ]))->hydrateFQCN($class, $json);
    }
}
