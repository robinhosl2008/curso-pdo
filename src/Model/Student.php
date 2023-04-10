<?php

namespace Alura\PDO\Model;
use DateTimeImmutable;
use DateTimeInterface;

class Student
{
    private ?int $id;
    private string $name;
    private DateTimeInterface $birthDay;

    public function __construct(?int $id, string $name, DateTimeInterface $birthDay)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDay = $birthDay;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDay(): DateTimeInterface
    {
        return $this->birthDay;
    }

    public function age(): int
    {
        return $this->birthDay
            ->diff(new DateTimeImmutable())
            ->y;
    }
}
