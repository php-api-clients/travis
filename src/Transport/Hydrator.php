<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Transport;

use GeneratedHydrator\Configuration;
use WyriHaximus\Travis\Resource\RepositoryInterface;
use WyriHaximus\Travis\Resource\ResourceInterface;
use Zend\Hydrator\HydratorInterface;

class Hydrator
{
    const RESOURCE_NAMESPACE = 'WyriHaximus\Travis\Resource\\';

    protected $options;
    protected $transport;
    protected $hydrators = [];

    public function __construct(Client $transport, array $options)
    {
        $this->transport = $transport;
        $this->options = $options;
    }

    public function hydrateFQCN($class, $json): ResourceInterface
    {
        return $this->getHydrator($class)->hydrate($json, $this->createObject($class));
    }

    public function hydrate($class, $json): ResourceInterface
    {
        $fullClassName = self::RESOURCE_NAMESPACE . $this->options['resource_namespace'] . '\\' . $class;
        return $this->hydrateFQCN($fullClassName, $json);
    }

    /**
     * Takes a fully qualified class name and extracts the data for that class from the given $object
     * @param $class
     * @param $object
     * @return array
     */
    public function extractFQCN($class, $object): array
    {
        return $this->getHydrator($class)->extract($object);
    }

    public function extract($class, $object): array
    {
        $fullClassName = self::RESOURCE_NAMESPACE . $this->options['resource_namespace'] . '\\' . $class;
        return $this->extractFQCN($fullClassName, $object);
    }

    public function buildAsyncFromSync($resource, $object): ResourceInterface
    {
        return $this->hydrateFQCN(
            static::RESOURCE_NAMESPACE . 'Async\\' . $resource,
            $this->extractFQCN(
                static::RESOURCE_NAMESPACE . 'Sync\\' . $resource,
                $object
            )
        );
    }

    protected function getHydrator($class): HydratorInterface
    {
        if (isset($this->hydrators[$class])) {
            return $this->hydrators[$class];
        }

        $config = new Configuration($class);
        if (isset($this->options['resource_hydrator_cache_dir'])) {
            $config->setGeneratedClassesTargetDir($this->options['resource_hydrator_cache_dir']);
        }
        if (isset($this->options['resource_hydrator_namespace'])) {
            $config->setGeneratedClassesNamespace($this->options['resource_hydrator_namespace']);
        }
        $hydrator = $config->createFactory()->getHydratorClass();
        $this->hydrators[$class] = new $hydrator;

        return $this->hydrators[$class];
    }

    protected function createObject($class): ResourceInterface
    {
        $object = new $class();
        $object->setTransport($this->transport);
        return $object;
    }
}
