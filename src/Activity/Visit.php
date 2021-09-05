<?php

declare(strict_types=1);

namespace GroupLife\Core\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\Visitor;

class Visit
{
    private $time;
    private $status;
    private $visitor;
    private $activity;

    public function __construct(\DateTime $time, string $status, Visitor $visitor, Activity $activity)
    {
        $this->time = $time;
        $this->status = $status;
        $this->visitor = $visitor;
        $this->activity = $activity;
    }

    /**
     * @return Activity
     */
    public function getActivity(): Activity
    {
        return $this->activity;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * @return Visitor
     */
    public function getVisitor(): Visitor
    {
        return $this->visitor;
    }
}
