<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis;

use Phake;
use WyriHaximus\Travis\Transport\Client;
use WyriHaximus\Travis\Transport\Hydrator;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public function hydrate($class, $json, $namespace)
    {
        return (new Hydrator(Phake::mock(Client::class), [
            'resource_namespace' => $namespace,
        ]))->hydrateFQCN($class, $json);
    }
}
