<?php

namespace Tonysm\LocalTimeLaravel;

class LocalTimeLaravel
{
    const DEFAULT_TIME_FORMAT = 'F j, Y g:ia';
    const DEFAULT_DATE_FORMAT = 'F j, Y';

    private ?string $timeFormat = null;
    private ?string $dateFormat = null;

    public function useTimeFormat(string $format): self
    {
        $this->timeFormat = $format;

        return $this;
    }

    public function useDateFormat(string $format): self
    {
        $this->dateFormat = $format;

        return $this;
    }

    public function getTimeFormat()
    {
        return $this->timeFormat ?: static::DEFAULT_TIME_FORMAT;
    }

    public function getDateFormat()
    {
        return $this->dateFormat ?: static::DEFAULT_DATE_FORMAT;
    }
}
