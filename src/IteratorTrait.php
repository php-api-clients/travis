<?php

namespace WyriHaximus\Travis;

/**
 * @source https://github.com/jeremeamia/php-design-patterns/blob/master/src/Jeremeamia/PhpPatterns/Structural/Collection/IteratorTrait.php
 */
trait IteratorTrait
{
    private $container;

    protected function getData()
    {
        if ($this->container !== null) {
            return $this->container;
        }

        $this->container = $this->getClient()->request($this)->getIterator()->getArrayCopy();
        return $this->container;
    }

    protected $position = 0;

    public function key()
    {
        return $this->position;
    }

    public function current()
    {
        return $this->getData()[$this->position];
    }

    public function next()
    {
        return $this->position++;
    }

    public function prev()
    {
        return $this->position--;
    }

    public function rewind()
    {
        return $this->position = 0;
    }

    public function valid()
    {
        return array_key_exists($this->position, $this->getData());
    }

    public function seek($position)
    {
        $this->position = $position;

        if (!$this->valid()) {
            throw new \OutOfBoundsException("The key [{$position}] does not exist.");
        }
    }
}