<?php

namespace GroupLife\Core\Test\unit;

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function test()
    {
        $period = new \DateInterval('P1M');
        var_dump($period->format('P%yY%mM%dDT%hH%iM%sS'));
    }
}
