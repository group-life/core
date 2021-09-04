<?php

namespace GroupLife\Core\Schedule;

interface RuleInterface
{
    public function includedDays(\DateTime $from, \DateInterval $period): array;

    public function excludedDays(\DateTime $from, \DateInterval $period): array;
}
