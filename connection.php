<?php
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;

require_once 'vendor/autoload.php';

$conn = new ConnectionFactory();
$pdo = $conn->getPdo();

$pdo->exec("
    CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    birthDate TEXT);
");

echo 'Connection success!'.PHP_EOL;