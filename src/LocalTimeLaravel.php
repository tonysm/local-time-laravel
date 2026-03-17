<?php

namespace Tonysm\LocalTimeLaravel;

class LocalTimeLaravel
{
    const DEFAULT_TIME_FORMAT = 'F j, Y g:ia';

    const DEFAULT_NULL_TIME = ' -- ';

    const DEFAULT_DATE_FORMAT = 'F j, Y';

    private ?string $timeFormat = null;

    private ?string $nullTime = ' -- ';

    private ?string $dateFormat = null;

    public function useTimeFormat(string $format): self
    {
        $this->timeFormat = $format;

        return $this;
    }

    public function useNullTime(string $nullTime): self
    {
        $this->nullTime = $nullTime;

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

    public function getNullTime()
    {
        return $this->nullTime ?: static::DEFAULT_NULL_TIME;
    }

    public function getDateFormat()
    {
        return $this->dateFormat ?: static::DEFAULT_DATE_FORMAT;
    }
}
