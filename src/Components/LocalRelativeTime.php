<?php

namespace Tonysm\LocalTimeLaravel\Components;

use Carbon\CarbonInterface;
use Illuminate\View\Component;

class LocalRelativeTime extends Component
{
    public CarbonInterface $value;
    public string $type;

    public function __construct(
        CarbonInterface $value,
        string $type
    ) {
        $this->value = $value;
        $this->type = $type;
    }

    public function render()
    {
        return view('local-time-laravel::local-relative-time');
    }
}
