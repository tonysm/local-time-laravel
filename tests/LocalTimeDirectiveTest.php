<?php

use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;
use Tonysm\LaravelLocalTime\LaravelLocalTime;
use Tonysm\LaravelLocalTime\LocalTimeDirective;

class LocalTimeDirectiveTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->date = "2013-11-21";
        $this->timeUtc = "2013-11-21 06:00:00 UTC";
        $this->time = Carbon::parse($this->timeUtc)->toIso8601ZuluString();
        $this->timeJs = "2013-11-21T06:00:00Z";
        $this->localTime = new LaravelLocalTime();
        $this->directive = new LocalTimeDirective($this->localTime);

        Carbon::setTestNow(Carbon::parse($this->timeUtc)->toIso8601ZuluString());
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow(null);
    }

    /** @test */
    public function local_time()
    {
        $expected = <<<html
        <time data-format="%B %e, %Y %l:%M%P" data-local="time" datetime="{$this->timeJs}" >November 21, 2013 6:00am</time>
        html;

        $this->assertEquals($expected, $this->directive->time(Carbon::parse($this->time)));
    }

    /** @test */
    public function local_time_with_format()
    {
        $expected = <<<html
        <time data-format="%b %e" data-local="time" datetime="{$this->timeJs}" >Nov 21</time>
        html;

        $this->assertEquals($expected, $this->directive->time(Carbon::parse($this->time), 'M j'));
    }

    /** @test */
    public function local_time_with_attributes()
    {
        $expected = <<<html
        <time data-format="%b %e" data-local="time" datetime="{$this->timeJs}" style="display: none;">Nov 21</time>
        html;

        $this->assertEquals($expected, $this->directive->time(Carbon::parse($this->time), ['format' => 'M j', 'style' => 'display: none;']));
    }

    /** @test */
    public function local_date()
    {
        $expected = <<<html
        <time data-format="%B %e, %Y" data-local="time" datetime="{$this->timeJs}" >November 21, 2013</time>
        html;

        $this->assertEquals($expected, $this->directive->date(Carbon::parse($this->time)));
    }

    /** @test */
    public function local_date_with_format()
    {
        $expected = <<<html
        <time data-format="%b %e" data-local="time" datetime="{$this->timeJs}" >Nov 21</time>
        html;

        $this->assertEquals($expected, $this->directive->date(Carbon::parse($this->time), 'M j'));
    }

    /** @test */
    public function local_date_with_attributes()
    {
        $expected = <<<html
        <time data-format="%b %e" data-local="time" datetime="{$this->timeJs}" style="display: none;">Nov 21</time>
        html;

        $this->assertEquals($expected, $this->directive->time(Carbon::parse($this->time), ['format' => 'M j', 'style' => 'display: none;']));
    }

    /** @test */
    public function local_time_ago()
    {
        $expected = <<<html
        <time data-local="time-ago" datetime="{$this->timeJs}" >November 21, 2013 6:00am</time>
        html;

        $this->assertEquals($expected, $this->directive->timeAgo(Carbon::parse($this->time)));
    }

    /** @test */
    public function local_time_ago_with_options()
    {
        $expected = <<<html
        <time data-local="time-ago" datetime="{$this->timeJs}" class="date-time">November 21, 2013 6:00am</time>
        html;

        $this->assertEquals($expected, $this->directive->timeAgo(Carbon::parse($this->time), ['class' => 'date-time']));
    }

    /** @test */
    public function local_relative_time()
    {
        $expected = <<<html
        <time data-local="time-or-date" datetime="{$this->timeJs}" >November 21, 2013 6:00am</time>
        html;

        $this->assertEquals($expected, $this->directive->relativeTime(Carbon::parse($this->time), 'time-or-date'));
    }

    /** @test */
    public function local_relative_time_with_options()
    {
        $expected = <<<html
        <time data-local="time-or-date" datetime="{$this->timeJs}" class="date-time">November 21, 2013 6:00am</time>
        html;

        $this->assertEquals($expected, $this->directive->relativeTime(Carbon::parse($this->time), [
            'type' => 'time-or-date',
            'class' => 'date-time',
        ]));
    }
}
