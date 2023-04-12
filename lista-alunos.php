<?php
use Alura\PDO\Infrastructure\Persistence\ConnectionFactory;

require_once 'vendor/autoload.php';

$conn = new ConnectionFactory();
$pdo = $conn->getPdo();

$result = $pdo->query("SELECT * FROM students");
print_r($result->fetchAll(PDO::FETCH_ASSOC));
echo PHP_EOL;