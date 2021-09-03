<?php

namespace GroupLife\Core\Schedule;

class CancelDayRule implements RuleInterface
{
    private $days;

    public function __construct(array $days)
    {
        $this->days = $days;
    }

    public function includedDays(\DateTime $from, \DateInterval $period, array $schedule): array
    {
        return $schedule;
    }

    public function excludedDays(\DateTime $from, \DateInterval $period, array $schedule): array
    {
        $to = (clone $from)->add($period);
        foreach ($this->days as $day => $time) {
            $removeDay = \DateTime::createFromFormat('Y-m-dh:i', $day . $time);
            if ($removeDay >= $from && $removeDay <= $to) {
                for ($i = 0; $i < count($schedule); $i++) {
                    if ($schedule[$i] == $removeDay) {
                        unset($schedule[$i]);
                    }
                }
            }
        }
        return array_values($schedule);
    }
}
