<?php

declare(strict_types=1);

namespace GroupLife\Core\Activity;

use GroupLife\Core\Activity;

class Visit
{
    private $time;
    private $status;
    private $activity;

    public function __construct(\DateTime $time, Activity $activity)
    {
        $this->time = $time;
        $this->activity = $activity;
        $this->status = 'planned';
    }
}
