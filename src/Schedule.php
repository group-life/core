<?php

declare(strict_types=1);

namespace GroupLife\Core;

class Schedule
{

    /**
     * @var array
     */
    private $rules;

    /**
     * Schedule constructor.
     * @param Schedule\RuleInterface[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param \DateTime $from
     * @param \DateInterval $period
     *
     * @return \DateTime[]
     */
    public function materialize(\DateTime $from, \DateInterval $period): array
    {
        $to = \DateTime::createFromFormat('Y-m-d H:i', $from->format('Y-m-d H:i'));
        $to->add($period);
        $schedule = [];
        if ($from->format('l') != $this->rules[0]->getWeekday()) {
            $from->modify('next ' . $this->rules[0]->getWeekday());
        }
        $from->modify($this->rules[0]->getStartTime());

        while ($from <= $to) {
            $schedule[] = new \DateTime($from->format('Y-m-d H:i'));
            $from->add($this->rules[0]->getPeriod());
        }

        return $schedule;
    }
}
