<?php

namespace GroupLife\Core\Schedule;

class CancelDayRule implements RuleInterface, \JsonSerializable
{
    private $day;
    private $time;

    public function __construct(string $day, string $time)
    {
        $this->day = $day;
        $this->time = $time;
    }

    public function includedDays(\DateTimeImmutable $from, \DateInterval $period): array
    {
        return [];
    }

    public function excludedDays(\DateTimeImmutable $from, \DateInterval $period): array
    {
        $to = $from->add($period);
        $addDay = new \DateTimeImmutable($this->day . ' ' . $this->time);
        if ($addDay >= $from && $addDay <= $to) {
            return [$addDay];
        }
        return [];
    }

    public function jsonSerialize(): array
    {
        return [
            'day' => $this->day,
            'time' => $this->time
        ];
    }
}
