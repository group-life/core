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
        // TODO
        return [];
    }
}
