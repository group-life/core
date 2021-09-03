<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class WeekdayRule implements RuleInterface
{
    private $weekday;
    private $startTime;
    private $repeat;

    public function __construct(string $weekday, string $startTime)
    {
        $this->weekday = $weekday;
        $this->startTime = $startTime;
        $this->repeat = new \DateInterval('P1W');
    }

    public function includedDays(\DateTime $from, \DateInterval $period, array $schedule): array
    {

        $to = (clone $from)->add($period);
        if ($from->format('l') != $this->weekday) {
            $from->modify('next ' . $this->weekday);
        }
        $from->modify($this->startTime);

        while ($from <= $to) {
            $schedule[] = clone $from;
            $from->add($this->repeat);
        }
        return $schedule;
    }
    public function excludedDays(\DateTime $from, \DateInterval $period, array $schedule): array
    {
        return $schedule;
    }
}
