<?php
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;
use Alura\PDO\Model\Student;

require_once 'vendor/autoload.php';

$conn = new ConnectionFactory();
$pdo = $conn->getPdo();

$birthDate = new DateTimeImmutable('1982-03-27');
$student = new Student(null, 'Robson Lourenço', $birthDate);

$sql = "INSERT INTO students (name, birthDate) VALUES (:name, :birthDate)";
$pdoStartment = $pdo->prepare($sql);
$pdoStartment->bindValue(':name', $student->name());
$pdoStartment->bindValue(':birthDate', $student->birthDay()->format('Y-m-d'));

if ($pdoStartment->execute()) {
    echo "Student inserted.".PHP_EOL;
} else {
    throw new DomainException("Error to insert student.");
}