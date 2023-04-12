<?php

namespace Alura\PDO\Domain\Model;

require_once 'vendor/autoload.php';

use Alura\PDO\Domain\Repository\StudentRepository;
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;

class Student
{
    private ?int $id;
    private string $name;
    private DateTimeImmutable $birthDay;
    private ConnectionFactory $conn;
    private PDO $pdo;

    public function __construct(?int $id, string $name, DateTimeImmutable $birthDay)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDay = $birthDay;
        $this->conn = new ConnectionFactory();
        $this->pdo = $this->conn->getPdo();
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function defineId(int $id): void
    {
        $this->id = $id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    public function birthDate(): DateTimeInterface
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
