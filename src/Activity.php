<?php

namespace GroupLife\Core;

class Activity
{
    private $name;

    public function __construct(string $name)
    {
    $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }
}

