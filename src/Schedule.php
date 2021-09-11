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
     * @param \DateTimeImmutable $from
     * @param \DateInterval $period
     *
     * @return \DateTimeImmutable[]
     */
    public function materialize(\DateTimeImmutable $from, \DateInterval $period): array
    {
        $include = [];
        $exclude = [];
        foreach ($this->rules as $rule) {
            $include = array_merge($include, $rule->includedDays($from, $period));
        }
        foreach ($this->rules as $rule) {
            $exclude = array_merge($rule->excludedDays($from, $period));
        }
        if (!empty($exclude)) {
            return array_filter($include, function ($includedDay) use ($exclude) {
                foreach ($exclude as $excludedDay) {
                    return $includedDay != $excludedDay;
                }
            });
        }
        return $include;
    }
}
