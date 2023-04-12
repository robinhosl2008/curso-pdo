<?php

use Alura\PDO\Domain\Model\Student;
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;
use Alura\PDO\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$pdo = new PDO('sqlite::memory:');
$pdo->exec("
    CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    birthDate TEXT);
");

$studantRepository = new PdoStudentRepository($pdo);

$pdo->beginTransaction();

try {
    $studantA = new Student(null, "Aluno A", new DateTimeImmutable('1997-02-25'));
    $studantRepository->save($studantA);

    $studantB = new Student(null, "Aluno B", new DateTimeImmutable('2003-09-13'));
    $studantRepository->save($studantB);

    $pdo->commit();
} catch (\PDOException $e) {
    echo $e->getMessage();
    $pdo->rollBack();
}

$results = $studantRepository->allStudents();
foreach ($results as $result) {
    var_dump($result->name());
}

