<?php

namespace Tonysm\LocalTimeLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class LocalTimeLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'local-time');

        $this->configureComponents();
    }

    private function configureComponents(): void
    {
        $this->callAfterResolving('blade.compiler', function (BladeCompiler $blade): void {
            $blade->anonymousComponentPath(__DIR__.'/../resources/views/components', 'local-time');
        });
    }

    public function register(): void
    {
        $this->app->scoped('laravel-local-time', fn (): LocalTimeLaravel => new LocalTimeLaravel);
    }
}
