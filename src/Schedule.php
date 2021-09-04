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
        $schedule = [];
        foreach ($this->rules as $rule) {
            $schedule = $rule->includedDays($from, $period);
        }
        foreach ($this->rules as $rule) {
            $schedule = array_diff($schedule, $rule->excludedDays($from, $period));
        }
        return $schedule;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }
}
