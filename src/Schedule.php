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
     * @var int
     */
    private $id;
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
            $exclude = array_merge($exclude, $rule->excludedDays($from, $period));
        }
        if (!empty($exclude)) {
            return array_values(array_filter($include, function ($includedDay) use ($exclude) {
                foreach ($exclude as $excludedDay) {
                    if ($includedDay == $excludedDay) {
                        return false;
                    }
                }
                return true;
            }));
        }
        return $include;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $rules = [];
        foreach ($this->rules as $rule) {
            $object = new \stdClass();
            $object->type = get_class($rule);
            $object->data = json_encode($rule);
            $rules[] = $object;
        }
        return $rules;
    }

    /**
     * @param int $id
     */
    public function persists(int $id): void
    {
        $this->id = $id;
    }
}
