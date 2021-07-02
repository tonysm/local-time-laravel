<?php

namespace Tonysm\LocalTimeLaravel\Components;

use Carbon\CarbonInterface;
use Illuminate\View\Component;

class LocalTimeAgo extends Component
{
    public CarbonInterface $value;

    public function __construct(
        CarbonInterface $value
    ) {
        $this->value = $value;
    }

    public function render()
    {
        return view('local-time-laravel::local-time-ago');
    }
}
