<?php

namespace Core;
class Visitor
{
    private $name;
    private $surname;

    public function __construct($name, $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }
    public function returnFullName ()
    {
        return 'My name is ' . $this->name . ' ' . $this->surname;
    }
}
