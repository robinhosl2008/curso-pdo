<?php
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;

require_once 'vendor/autoload.php';

$conn = new ConnectionFactory();
$pdo = $conn->getPdo();

$pdo->exec("
    CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY,
        name TEXT,
        birthDate TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
        id INTEGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTEGER,
        FOREIGN KEY(student_id) REFERENCES students(id)
    );
");

echo 'Connection success!'.PHP_EOL;