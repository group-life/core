<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class DayRule implements RuleInterface
{

    private $days;

    public function __construct(array $days)
    {
        $this->days = $days;
    }

    public function includedDays(\DateTime $from, \DateInterval $period, array $schedule): array
    {
        $to = (clone $from)->add($period);
        foreach ($this->days as $day => $time) {
            $addDay = \DateTime::createFromFormat('Y-m-dh:i', $day . $time);
            if ($addDay >= $from && $addDay <= $to) {
                $schedule[] = clone $addDay;
            }
        }
        return $schedule;
    }
    public function excludedDays(\DateTime $from, \DateInterval $period, array $schedule): array
    {
        return $schedule;
    }
}
