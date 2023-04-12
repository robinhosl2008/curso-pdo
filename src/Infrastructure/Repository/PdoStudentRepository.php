<?php

namespace Alura\PDO\Infrastructure\Repository;

use DateTimeImmutable;
use PDO;
use DateTimeInterface;
use Alura\PDO\Domain\Model\Student;
use Alura\PDO\Domain\Repository\StudentRepository;
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;
use PDOStatement;

class PdoStudentRepository implements StudentRepository
{
    private PDO $pdo;

    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }

    public function allStudents(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM students;");
        return $this->hydrateStudentList($stmt);
    }

    public function studentsBirthDate(DateTimeInterface $birthDate): array
    {
        $sql = "SELECT * FROM students WHERE birthDate = :birthDate;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":birthDate", $birthDate->format("Y-m-d"), PDO::PARAM_STR);
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    public function hydrateStudentList(PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll();
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData["id"],
                $studentData["name"],
                new DateTimeImmutable($studentData["birthDate"])
            );
        }

        return $studentList;
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function insert(Student $student): bool
    {
        $insertSQL =  "INSERT INTO students (name, birthDate) VALUES (:name, :birthDate);";
        $stmt = $this->pdo->prepare($insertSQL);

        $success = $stmt->execute([
            ":name" => $student->name(),
            ":birthDate" => $student->birthDate()->format('Y-m-d')
        ]);

        $student->defineId($this->pdo->lastInsertId());

        return $success;
    }

    public function update(Student $student): bool
    {
        $stmt = $this->pdo->prepare("UPDATE students SET name = :name, birthDate = :birthDate WHERE id = :id;");
        return $stmt->execute([
            "name" => $student->name(),
            ":birthDate" => $student->birthDate(),
            ":id" => $student->id()
        ]);
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->bindValue(":id", $student->id(), PDO::PARAM_STR);
        return $stmt->execute();
    }
}