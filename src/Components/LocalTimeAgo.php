<?php

namespace Tonysm\LocalTimeLaravel\Components;

use Carbon\CarbonInterface;
use Illuminate\View\Component;

class LocalTimeAgo extends Component
{
    public function __construct(public CarbonInterface $value) {}

    public function render()
    {
        return view('local-time-laravel::local-time-ago');
    }
}
