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

        Blade::directive('localtime', function ($expression) {
            return "<?php echo app(\Tonysm\LocalTimeLaravel\LocalTimeDirective::class)->time($expression); ?>";
        });
        Blade::directive('localtimeago', function ($expression) {
            return "<?php echo app(\Tonysm\LocalTimeLaravel\LocalTimeDirective::class)->timeAgo($expression); ?>";
        });
        Blade::directive('localrelativetime', function ($expression) {
            return "<?php echo app(\Tonysm\LocalTimeLaravel\LocalTimeDirective::class)->relativeTime($expression); ?>";
        });
        Blade::directive('localdate', function ($expression) {
            return "<?php echo app(\Tonysm\LocalTimeLaravel\LocalTimeDirective::class)->date($expression); ?>";
        });
    }

    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'local-time-laravel');

        $this->app->scoped('laravel-local-time', function () {
            return new LocalTimeLaravel();
        });
    }
}
