@props(['value', 'type' => 'time-or-date'])

<x-local-time::time :value="$value" :type="$type" {{ $attributes }} />
