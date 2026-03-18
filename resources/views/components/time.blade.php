@props(['value', 'format' => null, 'type' => 'time'])

@php
$value = $value === null ? null : ($value->isUtc() ? $value->copy() : $value->copy()->utc());
$emptyPlaceholder = \Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade::getEmptyPlaceholder();
$format ??= \Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade::getTimeFormat();
$formatJS = strtr($format, [
    // Thanks to baptiste at php dot net: https://www.php.net/manual/en/function.strftime.php#96424
    // Day - no strf eq : S
    'd' => '%d',
    'D' => '%a',
    'j' => '%e',
    'l' => '%A',
    'N' => '%u',
    'w' => '%w',
    'z' => '%j',
    // Week - no date eq : %U, %W
    'W' => '%V',
    // Month - no strf eq : n, t
    'F' => '%B',
    'm' => '%m',
    'M' => '%b',
    // Year - no strf eq : L; no date eq : %C, %g
    'o' => '%G',
    'Y' => '%Y',
    'y' => '%y',
    // Time - no strf eq : B, G, u; no date eq : %r, %R, %T, %X
    'a' => '%P',
    'A' => '%p',
    'g' => '%l',
    'h' => '%I',
    'H' => '%H',
    'i' => '%M',
    's' => '%S',
    // Timezone - no strf eq : e, I, P, Z
    'O' => '%z',
    'T' => '%Z',
    // Full Date / Time - no strf eq : c, r; no date eq : %c, %D, %F, %x
    'U' => '%s',
]);
@endphp

<time
    @unless ($type !== "time")
    data-format="{{ $formatJS }}"
    @endif
    data-local="{{ $type }}"
    datetime="{{ $value?->toIso8601ZuluString() }}"
    {{ $attributes->except(['type']) }}
>{{ $value == null ? $emptyPlaceholder : $value?->format($format) }}</time>
