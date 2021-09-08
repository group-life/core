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

    public function __construct(\DateTime $time, Activity $activity, Visitor $visitor)
    {
        $this->time = $time;
        $this->activity = $activity;
        $this->status = 'planned';
        $this->visitor = $visitor;
    }
}
