<?php

namespace WyriHaximus\Travis;

class Build
{
    use ParentHasClientAwareTrait;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var int
     */
    protected $id;

    public function __construct(Repository $repository, \stdClass $build)
    {
        $this->setParent($repository);
        $this->repository = $repository;

        $this->id = $build->id;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function matrix()
    {

    }
}
