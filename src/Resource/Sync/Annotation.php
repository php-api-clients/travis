<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Annotation as BaseAnnotation;

class Annotation extends BaseAnnotation
{
    public function refresh() : Annotation
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
