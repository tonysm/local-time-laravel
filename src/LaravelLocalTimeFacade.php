<?php

namespace Tonysm\LaravelLocalTime;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tonysm\LaravelLocalTime\Skeleton\SkeletonClass
 */
class LaravelLocalTimeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-local-time';
    }
}
