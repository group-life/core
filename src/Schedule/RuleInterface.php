<?php

namespace GroupLife\Core\Schedule;

interface RuleInterface
{
    public function getPeriod();

    public function getWeekday();

    public function getStartTime();
}
