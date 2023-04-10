<?php
use Alura\PDO\Model\Student;

require_once 'vendor/autoload.php';

$pathDatabase = __DIR__ . '/database.sqlite';
$pdo = new PDO("sqlite:{$pathDatabase}");

$sql = "DELETE FROM students WHERE id = ?;";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, 3, PDO::PARAM_INT);
var_dump(($statement->execute()));