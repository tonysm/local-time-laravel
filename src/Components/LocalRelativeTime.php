<?php

namespace Tonysm\LocalTimeLaravel\Components;

use Carbon\CarbonInterface;
use Illuminate\View\Component;

class LocalRelativeTime extends Component
{
    public function __construct(public CarbonInterface $value, public string $type)
    {
    }

    public function render()
    {
        return view('local-time-laravel::local-relative-time');
    }
}
