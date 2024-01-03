<p align="center" style="margin-top: 2rem; margin-bottom: 2rem;"><img src="/art/local-time-laravel-logo.svg" alt="Logo Local Time Laravel" /></p>

<p align="center">
    <a href="https://github.com/tonysm/local-time-laravel/workflows/run-tests/badge.svg">
        <img src="https://github.com/tonysm/local-time-laravel/workflows/run-tests/badge.svg" />
    </a>
    <a href="https://packagist.org/packages/tonysm/local-time-laravel">
        <img src="https://img.shields.io/packagist/dt/tonysm/local-time-laravel" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/tonysm/local-time-laravel">
        <img src="https://img.shields.io/github/license/tonysm/local-time-laravel" alt="License">
    </a>
</p>

This is a Laravel port of the [`local_time`](https://github.com/basecamp/local_time) gem from Basecamp. It makes it easy to display date and time to users in their local time. Its Blade components render a `time` HTML tag in UTC (making it cache friendly), and the JavaScript component immediately converts those elements from UTC to the Browser's local time.

## Installation

1. Install the package via Composer:

```bash
composer require tonysm/local-time-laravel
```

2. Install the `local-time` JS lib via NPM:

```bash
npm install local-time -D
```

And then import it on your `resources/app.js` file, like so:

```js
// ...
import LocalTime from "local-time"
LocalTime.start()
```

## Usage

This package adds a couple Blade components to your project, they are:

```blade
<x-local-time :value="now()" />
```

Formats the Carbon instance using the default format string. It will convert the regular PHP formats to the `strftime` format for you.

```blade
<x-local-time :value="now()" format="F j, Y g:ia" />
```

Alias for `<x-local-time />` with a month-formatted default. It converts that format to `%B %e, %Y %l:%M%P`.

```blade
<x-local-date :value="now()" format="F j, Y" />
```

You can configure the format used by passing it as a prop to the component. Any other attribute will be rendered in the generated `time` tag.

```blade
<x-local-time :value="now()" class="my-time" />
```

Renders the `time` tag using the default time format and adds the given `class` tag attribute to the element.

Note: The included strftime JavaScript implementation is not 100% complete. It supports the following directives: `%a %A %b %B %c %d %e %H %I %l %m %M %p %P %S %w %y %Y %Z`

### Time ago helper

```blade
<x-local-time-ago :value="now()" />
```

Displays the relative amount of time passed. With age, the descriptions transition from {quantity of seconds, minutes, or hours} to {date + time} to {date}. The `<time>` elements are updated every 60 seconds.

Examples (in quotes):

- Recent: "a second ago", "32 seconds ago", "an hour ago", "14 hours ago"
- Yesterday: "yesterday at 5:22pm"
- This week: "Tuesday at 12:48am"
- This year: "on Nov 17"
- Last year: "on Jan 31, 2012"

### Relative time helper

Preset time and date formats that vary with age. The available types are date, time-ago, time-or-date, and weekday. Like the `<x-local-time />` component, `type` can be passed a string.

```blade
<x-local-relative-time :value="now()" type="weekday" />
<x-local-relative-time :value="now()" type="time-or-date" />
```

**Available `type` options:**

- `date`: Includes the year unless it's current. "Apr 11" or "Apr 11, 2013"
- `time-ago`: See above. `<x-local-time-ago />` calls `<x-local-time-relative />` with this `type` option.
- `time-or-date`: Displays the time if it occurs today or the date if not. "3:26pm" or "Apr 11"
- `weekday`: Displays "Today", "Yesterday", or the weekday (e.g. Wednesday) if the time is within a week of today.
- `weekday-or-date`: Displays the weekday if it occurs within a week or the date if not. "Yesterday" or "Apr 11"

### Example

```bash
php artisan tinker
>>> $user->created_at
=> Illuminate\Support\Carbon @1625103168 {#4106
     date: 2021-06-30 22:32:48.0 UTC (+00:00),
   }
```

```blade
<x-local-time :value="$user->created_at" />
```

Renders:

```html
<time data-format="%B %e, %Y %l:%M%P"
      data-local="time"
      datetime="2021-06-30T22:32:48Z">June 30, 2021 22:32pm</time>
```

And is converted client-side to:

```html
<time data-format="%B %e, %Y %l:%M%P"
      data-local="time"
      datetime="2021-06-30T22:32:48Z"
      title="June 30, 2013 22:32pm EDT"
      data-localized="true">June 30, 2021 22:32pm</time>
```

### Configuration

To configure the default date and time formats, you can use the `useTimeFormat` and `useDateFormat` methods on the `LocalTimeLaravelFacade` on your `AppServiceProvider`, like so:

```php
<?php

use Illuminate\Support\ServiceProvider;
use Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        LocalTimeLaravelFacade::useTimeFormat('H:i');
        LocalTimeLaravelFacade::useDateFormat('d/m/Y H:i');
    }
}
```

The JavaScript lib allows some configurations as well as internationalization (i18n). To know more about that, head out to the [Rails gem documentation](https://github.com/basecamp/local_time#configuration).

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email tonysm@hey.com instead of using the issue tracker.

## Credits

-   [Tony Messias](https://github.com/tonysm)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
