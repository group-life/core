<?php

declare(strict_types=1);

namespace GroupLife\Core\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\Visitor;

class Visit implements \JsonSerializable
{
    private $time;
    private $status;
    private $activity;
    private $visitor;

    /**
     * @param \DateTimeImmutable $time date and time of a visit
     * @param Activity $activity what activity to be visit
     * @param Visitor $visitor who will visit
     */
    public function __construct(\DateTimeImmutable $time, Activity $activity, Visitor $visitor)
    {
        $this->time = $time;
        $this->activity = $activity;
        $this->status = 'planned';
        $this->visitor = $visitor;
    }

    public function jsonSerialize(): \stdClass
    {
        $data = new \stdClass();
        $data->time = $this->time;
        $data->status = $this->status;
        $data->activity = $this->activity;
        $data->visitor = $this->visitor;
        return $data;
    }
}
