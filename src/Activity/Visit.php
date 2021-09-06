<?php

declare(strict_types=1);

namespace GroupLife\Core\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\Visitor;

class Visit
{
    private $time;
    private $status;
    private $activity;
    private $visitor;

    public function __construct(\DateTime $time, Activity $activity)
    {
        $this->time = $time;
        $this->activity = $activity;
        $this->status = 'planned';
    }

    public function createVisit(Visitor $visitor): string
    {
        $this->visitor = $visitor;
        if ($this->time === $this->activity->getTime()) {
            $this->status = 'confirmed';
        }
        return $this->status;
    }
}
