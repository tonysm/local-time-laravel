<?php

namespace Tonysm\LocalTimeLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Tonysm\LocalTimeLaravel\LocalTimeLaravel useDateFormat(string $format)
 * @method static \Tonysm\LocalTimeLaravel\LocalTimeLaravel useTimeFormat(string $format)
 * @method static \Tonysm\LocalTimeLaravel\LocalTimeLaravel getDateFormat()
 * @method static \Tonysm\LocalTimeLaravel\LocalTimeLaravel getTimeFormat()
 *
 * @see \Tonysm\LaravelLocalTime\LocalTimeLaravel
 */
class LocalTimeLaravelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-local-time';
    }
}
