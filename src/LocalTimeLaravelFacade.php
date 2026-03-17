<?php

namespace Tonysm\LocalTimeLaravel;

use Illuminate\Support\Facades\Facade;
use Tonysm\LaravelLocalTime\LocalTimeLaravel;

/**
 * @method static \Tonysm\LocalTimeLaravel\LocalTimeLaravel useDateFormat(string $format)
 * @method static \Tonysm\LocalTimeLaravel\LocalTimeLaravel useTimeFormat(string $format)
 * @method static \Tonysm\LocalTimeLaravel\LocalTimeLaravel useEmptyPlaceholder(string $emptyPlaceholder)
 * @method static string getDateFormat()
 * @method static string getTimeFormat()
 * @method static string getEmptyPlaceholder()
 *
 * @see LocalTimeLaravel
 */
class LocalTimeLaravelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-local-time';
    }
}
