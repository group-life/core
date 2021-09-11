<?php

declare(strict_types=1);

namespace GroupLife\Core;

class Visitor
{
    private $name;
    private $surname;

    public function __construct(string $name, string $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }
}
