<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource;

use Generator;
use Phake;
use ReflectionClass;
use WyriHaximus\Travis\Transport\Client;
use WyriHaximus\Travis\Transport\Hydrator;

abstract class AbstractResourceTest extends \PHPUnit_Framework_TestCase
{
    abstract public function getNamespace(): string;
    abstract public function getClass(): string;
    abstract public function hydrateProvider(): Generator;

    public function hydrate($class, $json)
    {
        return (new Hydrator(Phake::mock(Client::class), [
            'resource_namespace' => $this->getNamespace(),
        ]))->hydrateFQCN($class, $json);
    }

    /**
     * @dataProvider hydrateProvider
     */
    public function testHydrate(array $json, $value, string $method, string $type)
    {
        $class = Hydrator::RESOURCE_NAMESPACE . $this->getNamespace() . $this->getClass();
        $object = $this->hydrate(
            $class,
            $json + [
                'transport' => null,
            ]
        );
        $this->assertSame($type, (string)(new ReflectionClass($class))->getMethod($method)->getReturnType());
        $result = $object->$method();
        $this->assertSame($value, $result);
        if (interface_exists($type)) {
            $this->assertInstanceOf($type, $result);
        } else {
            $this->assertInternalType($type, $result);
        }
    }
}
