<?php

declare(strict_types=1);

namespace GroupLife\Core;

class Leader implements \JsonSerializable
{
    private $id;
    private $name;
    private $surname;

    public function __construct(string $name, string $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $data = new \stdClass();
        $data->id = $this->id;
        $data->name = $this->name;
        $data->surname = $this->surname;
        return $data;
    }

    /**
     * @param int $id
     */
    public function persists(int $id): void
    {
        $this->id = $id;
    }
}
