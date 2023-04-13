<?php
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;
use Alura\PDO\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$conn = new ConnectionFactory();
$pdo = $conn->getPdo();

$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudentWithPhones();

var_dump($studentList);


echo PHP_EOL;