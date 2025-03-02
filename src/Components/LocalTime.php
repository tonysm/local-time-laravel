<?php

namespace Tonysm\LocalTimeLaravel\Components;

use Carbon\CarbonInterface;
use Illuminate\View\Component;
use Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade;

class LocalTime extends Component
{
    public CarbonInterface $value;

    public string $format;

    public string $formatJS;

    public function __construct(
        CarbonInterface $value,
        string $format = '',
        public string $type = 'time'
    ) {
        $this->value = $this->utcDate($value);

        $format = $format ?: LocalTimeLaravelFacade::getTimeFormat();

        $this->format = $format;
        $this->formatJS = $this->strfTimeFormat($format);
    }

    private function utcDate(CarbonInterface $value): CarbonInterface
    {
        $value = $value->copy();

        return $value->isUtc() ? $value : $value->utc();
    }

    public function strfTimeFormat(string $format): string
    {
        // Thanks to baptiste at php dot net: https://www.php.net/manual/en/function.strftime.php#96424

        $charsMap = [
            // Day - no strf eq : S
            'd' => '%d', 'D' => '%a', 'j' => '%e', 'l' => '%A', 'N' => '%u', 'w' => '%w', 'z' => '%j',
            // Week - no date eq : %U, %W
            'W' => '%V',
            // Month - no strf eq : n, t
            'F' => '%B', 'm' => '%m', 'M' => '%b',
            // Year - no strf eq : L; no date eq : %C, %g
            'o' => '%G', 'Y' => '%Y', 'y' => '%y',
            // Time - no strf eq : B, G, u; no date eq : %r, %R, %T, %X
            'a' => '%P', 'A' => '%p', 'g' => '%l', 'h' => '%I', 'H' => '%H', 'i' => '%M', 's' => '%S',
            // Timezone - no strf eq : e, I, P, Z
            'O' => '%z', 'T' => '%Z',
            // Full Date / Time - no strf eq : c, r; no date eq : %c, %D, %F, %x
            'U' => '%s',
        ];

        return strtr($format, $charsMap);
    }

    public function render()
    {
        return view('local-time-laravel::local-time');
    }
}
