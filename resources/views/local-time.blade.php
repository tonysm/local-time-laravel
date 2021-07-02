<time
    @unless ($type !== "time")
    data-format="{{ $formatJS }}"
    @endif
    data-local="{{ $type }}"
    datetime="{{ $value->toIso8601ZuluString() }}"
    {{ $attributes->except(['type']) }}
>{{ $value->format($format) }}</time>
