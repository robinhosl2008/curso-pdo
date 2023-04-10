<?php

require_once 'vendor/autoload.php';

$pathDatabase = __DIR__ . '/database.sqlite';
$pdo = new PDO("sqlite:{$pathDatabase}");

echo 'Connection success!'.PHP_EOL;

$pdo->exec("
    CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    birthDate TEXT);
");