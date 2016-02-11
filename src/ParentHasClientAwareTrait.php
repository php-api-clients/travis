<?php

namespace WyriHaximus\Travis;

trait ParentHasClientAwareTrait
{
    /**
     * @var EndpointInterface
     */
    protected $parent;

    protected function setParent(EndpointInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getClient(): Client
    {
        return $this->parent->getClient();
    }
}
