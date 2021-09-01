<?php

namespace GroupLife\Core;

class Schedule
{
    public static $schedule = [];
    private $from;
    private $to;
    private $repeat;

    public function __construct(\DateTime $from, \DateTime $to, string $repeat = 'every day at 8')
    {
        $this->from = $from;
        $this->to = $to;
        $this->repeat = $repeat;
        self::materialize($this->from, $this->to);
    }
    public static function materialize(\DateTime $from, \DateTime $to)
    {
        if ($from < $to) {
            array_push(self::$shedule, $from);
            self::materialize($from->add(new \DateInterval('P1D')), $to);
        }
    }
}
