<?php

namespace Tonysm\LocalTimeLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use RuntimeException;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process as ComponentProcess;
use Tonysm\LocalTimeLaravel\LocalTimeLaravelServiceProvider;

class InstallCommand extends Command
{
    const JS_LIBS_IMPORT_PATTERN = '/import [\'\"](?:\.\/)?libs\/localtime[\'\"];?/';

    public $signature = 'localtime:install';

    public $description = 'Installs the package.';

    public function handle(): int
    {
        if ($this->usingImportmaps()) {
            $this->publishAssets();
            $this->updateJsDependenciesWithImportmaps();
        } else {
            $this->updateJsDependenciesWithNpm();
        }

        $this->ensureJsLibIsImported();

        $this->newLine();
        $this->components->info('Local Time Laravel was installed successfully.');

        return self::SUCCESS;
    }

    private function ensureJsLibIsImported(): void
    {
        $trixRelativeDestinationPath = 'resources/js/libs/localtime.js';

        $trixAbsoluteDestinationPath = base_path($trixRelativeDestinationPath);

        if (File::exists($trixAbsoluteDestinationPath)) {
            $this->components->warn("File {$trixRelativeDestinationPath} already exists.");
        } else {
            File::ensureDirectoryExists(dirname($trixAbsoluteDestinationPath), recursive: true);
            File::copy(__DIR__.'/../../resources/js/libs/localtime.js', $trixAbsoluteDestinationPath);
        }

        $entrypoint = Arr::first([
            resource_path('js/libs/index.js'),
            resource_path('js/app.js'),
        ], fn ($file): bool => file_exists($file));

        if (! $entrypoint) {
            return;
        }

        if (preg_match(self::JS_LIBS_IMPORT_PATTERN, File::get($entrypoint))) {
            return;
        }

        File::prepend($entrypoint, str_replace('%path%', $this->usingImportmaps() ? '' : './', <<<'JS'
        import "%path%libs/localtime";

        JS));
    }

    private function usingImportmaps(): bool
    {
        return File::exists(base_path('routes/importmap.php'));
    }

    private function publishAssets(): void
    {
        Process::forever()->run([
            $this->phpBinary(),
            'artisan',
            'vendor:publish',
            '--tag',
            'local-time-laravel-assets',
            '--provider',
            LocalTimeLaravelServiceProvider::class,
        ], fn ($_type, $output) => $this->output->write($output));
    }

    private function updateJsDependenciesWithImportmaps(): void
    {
        File::append(base_path('routes/importmap.php'), <<<'PHP'

        Importmap::pin('local-time', to: '/vendor/local-time-laravel/local-time.js');

        PHP);
    }

    private function updateJsDependenciesWithNpm(): void
    {
        static::updateNodePackages(fn ($packages): array => $this->jsDependencies() + $packages);

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }
    }

    private function runCommands(array $commands): void
    {
        $process = ComponentProcess::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, string $line): void {
            $this->output->write('    '.$line);
        });
    }

    private function jsDependencies(): array
    {
        return [
            'local-time' => '^3.0.3',
        ];
    }

    private function phpBinary(): string
    {
        return (new PhpExecutableFinder)->find(false) ?: 'php';
    }

    /**
     * Update the "package.json" file.
     *
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
