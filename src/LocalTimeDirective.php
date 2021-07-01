<?php

namespace Tonysm\LaravelLocalTime;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Illuminate\View\ComponentAttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;

class LocalTimeDirective
{
    private $localTime;

    public function __construct(LaravelLocalTime $localTime)
    {
        $this->localTime = $localTime;
    }

    public function time(Carbon $carbon, $options = [])
    {
        [$options, $format] = $this->extractOption($options, 'format');

        $format = $format ?: $this->localTime->getTimeFormat();

        return $this->tagTime($carbon, $format, $options);
    }

    private function extractOption($options, string $key)
    {
        if (is_array($options) && ! empty($options)) {
            return [Arr::except($options, $key), Arr::get($options, $key)];
        }

        return [[], $options];
    }

    private function tagTime(Carbon $carbon, string $format, $options = [])
    {
        $carbon = $carbon->copy();
        $carbon = $carbon->isUtc() ? $carbon : $carbon->utc();

        $strftime = $this->toStrfTimeFormat($format);
        [$options, $type] = $this->extractOption($options, 'type');

        $type = $type ?: 'time';

        $attributes = new ComponentAttributeBag(Arr::wrap($options));

        $formatAttr = $type === 'time'
            ? sprintf(' data-format="%s" ', $strftime)
            : ' ';

        return new HtmlString(<<<html
        <time{$formatAttr}data-local="{$type}" datetime="{$carbon->toIso8601ZuluString()}" {$attributes->toHtml()}>{$carbon->format($format)}</time>
        html);
    }

    private function toStrfTimeFormat(string $format)
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
            'U' => '%s'
        ];

        return strtr($format, $charsMap);
    }

    public function date(Carbon $carbon, $options = [])
    {
        [$options, $format] = $this->extractOption($options, 'format');
        $options['format'] = $format ?: $this->localTime->getDateFormat();

        return $this->time($carbon, $options);
    }

    public function timeAgo(Carbon $carbon, $options = [])
    {
        return $this->time($carbon, Arr::wrap($options) + ['type' => 'time-ago']);
    }

    public function relativeTime(Carbon $carbon, $options = [])
    {
        [$options, $type] = $this->extractOption($options, 'type');

        return $this->time($carbon, array_merge($options, [
            'type' => $type,
        ]));
    }
}
