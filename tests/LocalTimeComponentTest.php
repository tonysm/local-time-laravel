<?php

namespace Tonysm\LocalTimeLaravel\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithTime;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade;

class LocalTimeComponentTest extends TestCase
{
    use InteractsWithTime;
    use InteractsWithViews;

    private string $time;

    private string $timeUTC;

    private string $timeJS;

    protected function setUp(): void
    {
        parent::setUp();

        $this->timeUTC = '2013-11-21 06:00:00 UTC';
        $this->time = Carbon::parse($this->timeUTC)->toIso8601ZuluString();
        $this->timeJS = '2013-11-21T06:00:00Z';

        $this->travel(Carbon::parse($this->timeUTC)->toIso8601ZuluString());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->travelBack();
    }

    #[Test]
    public function renders_local_time(): void
    {
        $view = $this->blade('<x-local-time :value="$date" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
        ]);

        $view->assertSee('data-format="%B %e, %Y %l:%M%P"', false);
        $view->assertSee('data-local="time"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getTimeFormat()), true);
    }

    #[Test]
    public function renders_local_time_with_format(): void
    {
        $view = $this->blade('<x-local-time :value="$date" :format="$format" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
            'format' => $format = 'M j',
        ]);

        $view->assertSee('data-format="%b %e"', false);
        $view->assertSee('data-local="time"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee($date->format($format), true);
    }

    #[Test]
    public function renders_local_time_with_attributes(): void
    {
        $view = $this->blade('<x-local-time :value="$date" style="display: none;" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
        ]);

        $view->assertSee('data-format="%B %e, %Y %l:%M%P"', false);
        $view->assertSee('data-local="time"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee('style="display: none;"', false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getTimeFormat()));
    }

    #[Test]
    public function renders_date(): void
    {
        $view = $this->blade('<x-local-date :value="$date" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
        ]);

        $view->assertSee('data-format="%B %e, %Y"', false);
        $view->assertSee('data-local="time"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getDateFormat()));
    }

    #[Test]
    public function renders_date_with_format(): void
    {
        $view = $this->blade('<x-local-date :value="$date" :format="$format" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
            'format' => $format = 'M j',
        ]);

        $view->assertSee('data-format="%b %e"', false);
        $view->assertSee('data-local="time"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee($date->format($format));
    }

    #[Test]
    public function renders_date_with_attributes(): void
    {
        $view = $this->blade('<x-local-date :value="$date" class="date-time" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
        ]);

        $view->assertSee('data-format="%B %e, %Y"', false);
        $view->assertSee('data-local="time"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee('class="date-time"', false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getDateFormat()));
    }

    #[Test]
    public function renders_local_time_ago(): void
    {
        $view = $this->blade('<x-local-time-ago :value="$date" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
        ]);

        $view->assertDontSee('data-format');
        $view->assertDontSee('ago="ago"', false);
        $view->assertSee('data-local="time-ago"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getDateFormat()));
    }

    #[Test]
    public function renders_local_time_ago_with_options(): void
    {
        $view = $this->blade('<x-local-time-ago :value="$date" class="date-time" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
        ]);

        $view->assertDontSee('data-format');
        $view->assertSee('data-local="time-ago"', false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee('class="date-time"', false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getDateFormat()));
    }

    #[Test]
    public function renders_local_relative_time(): void
    {
        $view = $this->blade('<x-local-relative-time :value="$date" :type="$type" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
            'type' => $type = 'time-or-date',
        ]);

        $view->assertDontSee('data-format');
        $view->assertDontSee('type="', false);
        $view->assertSee(sprintf('data-local="%s"', $type), false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getDateFormat()));
    }

    #[Test]
    public function renders_local_relative_time_with_options(): void
    {
        $view = $this->blade('<x-local-relative-time :value="$date" :type="$type" class="date-time" />', [
            'date' => $date = Carbon::parse($this->timeUTC),
            'type' => $type = 'weekday',
        ]);

        $view->assertDontSee('data-format');
        $view->assertDontSee('type="', false);
        $view->assertSee(sprintf('data-local="%s"', $type), false);
        $view->assertSee(sprintf('datetime="%s"', $this->timeJS), false);
        $view->assertSee('class="date-time"', false);
        $view->assertSee($date->format(LocalTimeLaravelFacade::getDateFormat()));
    }

    #[Test]
    public function renders_empty_placeholder_when_value_is_null(): void
    {
        $view = $this->blade('<x-local-time :value="$date" />', [
            'date' => null,
        ]);

        $view->assertSee(' -- ');
        $view->assertSee('datetime=""', false);
    }

    #[Test]
    public function renders_custom_empty_placeholder(): void
    {
        LocalTimeLaravelFacade::useEmptyPlaceholder('N/A');

        $view = $this->blade('<x-local-time :value="$date" />', [
            'date' => null,
        ]);

        $view->assertSee('N/A');
        $view->assertDontSee(' -- ');
    }

    #[Test]
    public function renders_empty_placeholder_for_local_date_with_null_value(): void
    {
        $view = $this->blade('<x-local-date :value="$date" />', [
            'date' => null,
        ]);

        $view->assertSee(' -- ');
        $view->assertSee('datetime=""', false);
    }
}
