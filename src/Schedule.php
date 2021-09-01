<?php

declare(strict_types=1);

namespace GroupLife\Core;

use GroupLife\Core\Schedule\Weekday;

class Schedule
{
    private array $schedule;
    private string $weekday;
    private string $startTime;
    private \DateInterval $period;
    private \DateInterval $duration;

    public function __construct($rules)
    {
        $this->weekday = $rules->getWeekday();
        $this->startTime = $rules->getStartTime();
        $this->period = $rules->getPeriod();
        $this->duration = $rules->getDuration();
    }

    /**
     * @return \DateInterval
     */

    public function materialize(\DateTime $from, \DateTime $to)
    {
        if ($from->format('l') != $this->weekday) {
            $from->modify('next ' . $this->weekday);
        }
        $from->modify($this->startTime);

        while ($from <= $to) {
            $this->schedule[] = $from->format('Y-m-d H:i:s');
            $from->add($this->period);
        }

        return $this->schedule;
    }
}
