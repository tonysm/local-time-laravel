<?php

namespace Tonysm\LocalTimeLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Tonysm\LocalTimeLaravel\Console\InstallCommand;

class LocalTimeLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'local-time');

        $this->configureComponents();
        $this->configurePublicAssets();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    private function configureComponents(): void
    {
        $this->callAfterResolving('blade.compiler', function (BladeCompiler $blade): void {
            $blade->anonymousComponentPath(__DIR__.'/../resources/views/components', 'local-time');
        });
    }

    private function configurePublicAssets(): void
    {
        $this->publishes([
            __DIR__.'/../resources/dist' => public_path('vendor/local-time-laravel'),
        ], 'local-time-laravel-assets');
    }

    public function register(): void
    {
        $this->app->scoped('laravel-local-time', fn (): LocalTimeLaravel => new LocalTimeLaravel);
    }
}
