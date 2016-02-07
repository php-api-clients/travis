<?php

namespace WyriHaximus\Travis;

use React\Promise\RejectedPromise;

/**
 * Class LazyPromise transformed into a trait
 * @source https://github.com/reactphp/promise/blob/fe0d75d660486677791fde20e82d263ab9d1c936/src/LazyPromise.php
 * @package WyriHaximus\Travis
 */
trait LazyPromiseTrait
{
    private $factory;
    private $promise;

    public function setFactory(callable $factory)
    {
        $this->factory = $factory;
    }

    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        return $this->promise()->then($onFulfilled, $onRejected, $onProgress);
    }

    public function done(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        return $this->promise()->done($onFulfilled, $onRejected, $onProgress);
    }

    public function otherwise(callable $onRejected)
    {
        return $this->promise()->otherwise($onRejected);
    }

    public function always(callable $onFulfilledOrRejected)
    {
        return $this->promise()->always($onFulfilledOrRejected);
    }

    public function progress(callable $onProgress)
    {
        return $this->promise()->progress($onProgress);
    }

    public function cancel()
    {
        return $this->promise()->cancel();
    }

    private function promise()
    {
        if (null === $this->promise) {
            try {
                $this->promise = \React\Promise\resolve(call_user_func($this->factory));
            } catch (\Exception $exception) {
                $this->promise = new RejectedPromise($exception);
            }
        }

        return $this->promise;
    }
}
