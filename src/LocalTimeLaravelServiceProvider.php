<?php

namespace Tonysm\LocalTimeLaravel;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LocalTimeLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'local-time-laravel');

        if ($this->app->runningInConsole()) {
            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-local-time'),
            ], 'assets');
        }

        Blade::component('local-time', Components\LocalTime::class);
        Blade::component('local-date', Components\LocalDate::class);
        Blade::component('local-time-ago', Components\LocalTimeAgo::class);
        Blade::component('local-relative-time', Components\LocalRelativeTime::class);
    }

    public function register(): void
    {
        $this->app->scoped('laravel-local-time', fn(): \Tonysm\LocalTimeLaravel\LocalTimeLaravel => new LocalTimeLaravel());
    }
}
