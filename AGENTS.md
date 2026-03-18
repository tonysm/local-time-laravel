# AGENTS.md

## Project Overview

Laravel package (`tonysm/local-time-laravel`) that provides Blade components rendering `<time>` tags in UTC, converted client-side to local timezone via the `local-time` JS library. Port of Basecamp's `local_time` Ruby gem.

- **Namespace**: `Tonysm\LocalTimeLaravel\`
- **PHP**: ^8.2
- **Laravel**: ^11.0 | ^12.0 | ^13.0
- **Test harness**: Orchestra Testbench (provides full Laravel app environment for package testing)

## Build / Test / Lint Commands

### Tests
```bash
# Run all tests
composer test
# or
vendor/bin/phpunit

# Run a single test by method name
vendor/bin/phpunit --filter=renders_local_time

# Run a single test (fully qualified)
vendor/bin/phpunit --filter=LocalTimeComponentTest::renders_local_time

# Run a single test class
vendor/bin/phpunit --filter=LocalTimeComponentTest

# Run with HTML coverage report
composer test-coverage
```

### Linting / Formatting
```bash
# Auto-fix code style (Laravel Pint, default Laravel preset)
vendor/bin/pint

# Check only (no auto-fix)
vendor/bin/pint --test
```

### Rector (Automated Refactoring)
```bash
# Run rector (dry-run)
vendor/bin/rector --dry-run

# Apply rector fixes
vendor/bin/rector
```

Rector is configured (`rector.php`) for PHP 8.2 with these rule sets: deadCode, codeQuality, typeDeclarations, privatization, earlyReturn.

## CI Pipeline

- **Tests**: Matrix of PHP 8.2–8.5, Laravel 11–13, ubuntu + windows, prefer-lowest + prefer-stable
- **Linting**: Laravel Pint runs on every push and auto-commits fixes with message "Fix styling"

Always run `vendor/bin/pint` and `vendor/bin/phpunit` before committing.

## Code Style Guidelines

### Formatting
- **Style tool**: Laravel Pint with the default Laravel preset (no `pint.json` override)
- **Indentation**: 4 spaces (see `.editorconfig`)
- **Line endings**: LF
- **Final newline**: Required
- **Trailing whitespace**: Trimmed (except `.md` files)
- **YAML files**: 2-space indent

### Imports
- One `use` statement per line, at the top of the file
- Fully qualified class names in Blade templates (e.g., `\Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade::getTimeFormat()`)
- No unused imports — Pint and Rector will flag these
- Group order follows Laravel Pint defaults: PHP core, vendor, application

### Types and Type Hints
- Use PHP type declarations on all method parameters and return types
- Use nullable types with `?` prefix (e.g., `?string`)
- Use `void` return type on methods that return nothing (including `setUp`, `tearDown`, test methods)
- Use `self` return type for fluent setter methods
- Class properties must be typed (e.g., `private ?string $timeFormat = null;`)
- Use `@method` docblocks on Facade classes for IDE support
- Arrow functions for short closures: `fn(): LocalTimeLaravel => new LocalTimeLaravel`

### Naming Conventions
- **Classes**: PascalCase, suffixed by role (`*Facade`, `*ServiceProvider`, `*Test`)
- **Methods**: camelCase (e.g., `useTimeFormat()`, `getDateFormat()`)
- **Test methods**: snake_case (e.g., `renders_local_time_with_format()`)
- **Variables**: camelCase (e.g., `$emptyPlaceholder`, `$formatJS`)
- **Constants**: UPPER_SNAKE_CASE (e.g., `DEFAULT_TIME_FORMAT`)
- **Blade component files**: lowercase single-word or kebab-case (e.g., `datetime.blade.php`, `ago.blade.php`)
- **Blade component prefix**: `local-time` (usage: `<x-local-time::datetime>`)

### Error Handling
- Handle null values gracefully with nullsafe operator (`?->`) and fallback placeholders
- No try/catch blocks in this package — exceptions propagate to the consuming application
- No custom exception classes — this is intentional for a small utility package

### Testing Conventions
- Test framework: PHPUnit 10+/11+ with Orchestra Testbench
- Base class: `Tonysm\LocalTimeLaravel\Tests\TestCase` (extends `Orchestra\Testbench\TestCase`)
- All tests extend the local `TestCase`, which registers the package service provider
- Use `#[Test]` attribute (not `test` method prefix) for test discovery
- Use traits: `InteractsWithTime` for time travel, `InteractsWithViews` for Blade rendering
- Test Blade components with `$this->blade($template, $data)` and assert with `assertSee()` / `assertDontSee()`
- Use `$this->travel()` / `$this->travelBack()` for time-dependent tests
- Test methods must be `public` with `: void` return type

### Package Architecture
- **Service container binding**: `scoped('laravel-local-time', ...)` — per-request singleton
- **Blade components**: Anonymous components registered via `anonymousComponentPath()` with `local-time` prefix
- **View namespace**: `local-time` (views loaded from `resources/views/`)
- **No config file publishing** — configuration is done programmatically via the Facade

## File Structure

```
src/
├── LocalTimeLaravel.php                # Core class (format getters/setters)
├── LocalTimeLaravelFacade.php          # Facade
└── LocalTimeLaravelServiceProvider.php # Service provider, component registration
resources/views/components/
├── ago.blade.php                       # <x-local-time::ago>
├── date.blade.php                      # <x-local-time::date>
├── datetime.blade.php                  # <x-local-time::datetime> (main component)
└── relative.blade.php                  # <x-local-time::relative>
tests/
├── TestCase.php                        # Base test case (Orchestra Testbench)
└── LocalTimeComponentTest.php          # All component tests
```

## Key Dependencies
- `illuminate/support` — Laravel service provider, facades, Carbon
- `orchestra/testbench` (dev) — Package testing with full Laravel environment
- `laravel/pint` (dev) — Code formatting
- `rector/rector` (dev) — Automated refactoring and code quality
