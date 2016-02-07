<?php

namespace WyriHaximus\Travis;

class Job
{
    use ParentHasClientAwareTrait;

    /**
     * @var Build
     */
    protected $build;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $php = '';

    /**
     * @var string
     */
    protected $env = '';

    public function __construct(Build $build, \stdClass $job)
    {
        $this->setParent($build);
        $this->build = $build;

        $this->id  = $job->id;
        $this->php = $job->config->php;
        if (isset($job->config->env)) {
            $this->env = $job->config->env;
        }
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPhp(): string
    {
        return $this->php;
    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }
}
