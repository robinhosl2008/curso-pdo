<?php

namespace Alura\PDO\Domain\Repository;

use Alura\PDO\Domain\Model\Student;
use DateTimeInterface;

interface StudentRepository
{
    public function allStudents(): array;
    public function allStudentWithPhones(): array;
    public function studentsBirthDate(DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}