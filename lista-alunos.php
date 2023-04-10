<?php

require_once 'vendor/autoload.php';

$pathDatabase = __DIR__ . '/database.sqlite';
$pdo = new PDO("sqlite:{$pathDatabase}");

$result = $pdo->query("SELECT * FROM students");
print_r($result->fetchAll(PDO::FETCH_ASSOC));
echo PHP_EOL;