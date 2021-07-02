<?php

namespace Tonysm\LocalTimeLaravel;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LocalTimeLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::component('local-time', Components\LocalTime::class);
        Blade::component('local-date', Components\LocalDate::class);
        Blade::component('local-time-ago', Components\LocalTimeAgo::class);
        Blade::component('local-relative-time', Components\LocalRelativeTime::class);
    }

    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'local-time-laravel');

        $this->app->scoped('laravel-local-time', function () {
            return new LocalTimeLaravel();
        });
    }
}
