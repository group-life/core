<?php

namespace GroupLife\Core\Schedule;

class CancelDayRule implements RuleInterface
{
    private $days;

    public function __construct(array $days)
    {
        $this->days = $days;
    }

    public function includedDays(\DateTime $from, \DateInterval $period): array
    {
        return [];
    }

    public function excludedDays(\DateTime $from, \DateInterval $period): array
    {
        $schedule = [];
        $to = (clone $from)->add($period);
        foreach ($this->days as $day => $time) {
            $addDay = \DateTime::createFromFormat('Y-m-dh:i', $day . $time);
            if ($addDay >= $from && $addDay <= $to) {
                $schedule[] = clone $addDay;
            }
        }
        return $schedule;
    }
}
