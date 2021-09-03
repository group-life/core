<?php

declare(strict_types=1);

namespace GroupLife\Core;

class Schedule
{

    /**
     * @var array
     */
    private $rules;
    private $schedule = [];
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
        foreach ($this->rules as $rule) {
            $this->schedule = $rule->includedDays($from, $period, $this->schedule);
        }
        foreach ($this->rules as $rule) {
            $this->schedule = $rule->excludedDays($from, $period, $this->schedule);
        }
            return $this->schedule;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }
}
