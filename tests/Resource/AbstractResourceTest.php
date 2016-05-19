<?php
declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource;

use Generator;
use ReflectionClass;
use WyriHaximus\Tests\Travis\TestCase;
use WyriHaximus\Travis\ApiSettings;

abstract class AbstractResourceTest extends TestCase
{
    abstract public function getNamespace(): string;
    abstract public function getClass(): string;
    abstract public function hydrateProvider(): Generator;

    /**
     * @dataProvider hydrateProvider
     */
    public function testHydrate(array $json, $value, string $method, string $type)
    {
        $class = ApiSettings::TRANSPORT_OPTIONS['namespace'] . '\\' . $this->getNamespace() . $this->getClass();
        $object = $this->hydrate(
            $class,
            $json + [
                'transport' => null,
            ],
            $this->getNamespace()
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
