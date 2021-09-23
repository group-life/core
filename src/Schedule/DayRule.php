<?php

declare(strict_types=1);

namespace GroupLife\Core\Schedule;

class DayRule implements RuleInterface, \JsonSerializable
{
    /**
     * @var \DateTimeImmutable
     */
    private $dateTime;

    /**
     * @param \DateTimeImmutable $dateTime exact date and time
     */
    public function __construct(\DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function includedDays(\DateTimeImmutable $from, \DateInterval $period): array
    {
        if ($from <= $this->dateTime && $this->dateTime <= (clone $from)->add($period)) {
            return [$this->dateTime];
        }

        return [];
    }

    public function excludedDays(\DateTimeImmutable $from, \DateInterval $period): array
    {
        return [];
    }

    public function jsonSerialize(): array
    {
        return [
            'dateTime' => $this->dateTime,
        ];
    }
}
