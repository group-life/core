<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class WeekdayRule implements RuleInterface
{
    private $weekday;
    private $startTime;

    public function __construct(string $weekday, string $startTime)
    {
        $this->weekday = $weekday;
        $this->startTime = $startTime;
    }

    public function includedDays(\DateTimeImmutable $from, \DateInterval $period): array
    {
        $to = $from->add($period);

        if ($from->format('l') !== $this->weekday) {
            $from = $from->modify('next ' . $this->weekday);
        }
        $from = $from->modify($this->startTime);

        $schedule = [];
        while ($from <= $to) {
            $schedule[] = $from;
            $from = $from->add(new \DateInterval('P1W'));
        }

        return $schedule;
    }

    public function excludedDays(\DateTimeImmutable $from, \DateInterval $period): array
    {
        return [];
    }
}
