<?php

namespace GroupLife\Core\Schedule;

interface RuleInterface
{
    public function includedDays(\DateTimeImmutable $from, \DateInterval $period): array;

    public function excludedDays(\DateTimeImmutable $from, \DateInterval $period): array;
}
