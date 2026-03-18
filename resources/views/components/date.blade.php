@props(['value', 'format' => null])

<x-local-time::time :value="$value" :format="$format ?? \Tonysm\LocalTimeLaravel\LocalTimeLaravelFacade::getDateFormat()" {{ $attributes }} />
