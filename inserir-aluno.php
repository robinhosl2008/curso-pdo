<?php
use Alura\PDO\Model\Student;

require_once 'vendor/autoload.php';

$pathDatabase = __DIR__ . '/database.sqlite';
$pdo = new PDO("sqlite:{$pathDatabase}");

$birthDate = new DateTimeImmutable('1982-03-27');
$student = new Student(null, 'Robson Lourenço4', $birthDate);

$sql = "INSERT INTO students (name, birthDate) VALUES (:name, :birthDate)";
$pdoStartment = $pdo->prepare($sql);
$pdoStartment->bindValue(':name', $student->name());
$pdoStartment->bindValue('birthDate', $student->birthDay()->format('Y-m-d'));

if ($pdoStartment->execute()) {
    echo "Aluno incluido.".PHP_EOL;
} else {
    throw new DomainException("Erro ao incluir o aluno.");
}