<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class DayRule implements RuleInterface
{

    private $day;
    private $time;

    public function __construct(string $day, string $time)
    {
        $this->day = $day;
        $this->time = $time;
    }

    public function includedDays(\DateTime $from, \DateInterval $period): array
    {
        $to = (clone $from)->add($period);
        $addDay = new \DateTime($this->day . ' ' . $this->time);
        if ($addDay >= $from && $addDay <= $to) {
            return [$addDay];
        }
        return [];
    }

    public function excludedDays(\DateTime $from, \DateInterval $period): array
    {
        return [];
    }
}
