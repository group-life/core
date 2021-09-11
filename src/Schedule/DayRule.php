<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class DayRule implements RuleInterface
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @param \DateTime $dateTime exact date and time
     */
    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function includedDays(\DateTime $from, \DateInterval $period): array
    {
        if ($from <= $this->dateTime && $this->dateTime <= (clone $from)->add($period)) {
            return [$this->dateTime];
        }

        return [];
    }

    public function excludedDays(\DateTime $from, \DateInterval $period): array
    {
        return [];
    }
}
