<?php

namespace Tonysm\LaravelLocalTime;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelLocalTimeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('localtime', function ($expression) {
            return "<?php echo app(\Tonysm\LaravelLocalTime\LocalTimeDirective::class)->time($expression); ?>";
        });
        Blade::directive('localtimeago', function ($expression) {
            return "<?php echo app(\Tonysm\LaravelLocalTime\LocalTimeDirective::class)->timeAgo($expression); ?>";
        });
        Blade::directive('localrelativetime', function ($expression) {
            return "<?php echo app(\Tonysm\LaravelLocalTime\LocalTimeDirective::class)->relativeTime($expression); ?>";
        });
        Blade::directive('localdate', function ($expression) {
            return "<?php echo app(\Tonysm\LaravelLocalTime\LocalTimeDirective::class)->date($expression); ?>";
        });
    }

    public function register()
    {
        $this->app->scoped('laravel-local-time', function () {
            return new LaravelLocalTime;
        });
    }
}
