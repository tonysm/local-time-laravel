<?php

namespace Tonysm\LocalTimeLaravel\Components;

use Carbon\CarbonInterface;
use Illuminate\View\Component;
use Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade;

class LocalDate extends Component
{
    public CarbonInterface $value;
    public string $format;

    public function __construct(
        CarbonInterface $value,
        string $format = ''
    ) {
        $this->value = $value;
        $this->format = $format ?: LocalTimeLaravelFacade::getDateFormat();
    }

    public function render()
    {
        return view('local-time-laravel::local-date');
    }
}
