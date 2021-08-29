<?php

class Visitor
{
    protected $_name;
    protected $_surname;

    public function __construct($name, $surname)
    {
        $this->_name = $name;
        $this->_surname = $surname;
    }
    public function returnFullName () {
        return 'My name is ' . $this->_name . ' ' . $this->_surname;
    }
}