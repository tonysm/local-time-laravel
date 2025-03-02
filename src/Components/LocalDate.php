<?php

namespace Tonysm\LocalTimeLaravel\Components;

use Carbon\CarbonInterface;
use Illuminate\View\Component;
use Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade;

class LocalDate extends Component
{
    public string $format;

    public function __construct(
        public CarbonInterface $value,
        string $format = ''
    ) {
        $this->format = $format ?: LocalTimeLaravelFacade::getDateFormat();
    }

    public function render()
    {
        return view('local-time-laravel::local-date');
    }
}
