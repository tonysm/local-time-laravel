<?php

namespace Tonysm\LaravelLocalTime;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Tonysm\LaravelLocalTime\LaravelLocalTime useDateFormat(string $format)
 * @method static \Tonysm\LaravelLocalTime\LaravelLocalTime useTimeFormat(string $format)
 * @method static \Tonysm\LaravelLocalTime\LaravelLocalTime getDateFormat()
 * @method static \Tonysm\LaravelLocalTime\LaravelLocalTime getTimeFormat()
 *
 * @see \Tonysm\LaravelLocalTime\LaravelLocalTime
 */
class LaravelLocalTimeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-local-time';
    }
}
