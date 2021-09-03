<?php

namespace GroupLife\Core\Schedule;

interface RuleInterface
{
    public function includedDays(\DateTime $from, \DateInterval $period, array $schedule): array;

    public function excludedDays(\DateTime $from, \DateInterval $period, array $schedule): array;
}
