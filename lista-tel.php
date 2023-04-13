<?php

require_once 'vendor/autoload.php';

$pathToDatabase = __DIR__ . '/database.sqlite';
$conn = new PDO("sqlite:{$pathToDatabase}");

// $stmt = $conn->prepare("INSERT INTO phones (area_code, number, student_id) VALUES (?, ?, ?)");
// $stmt->bindValue(1, '21');
// $stmt->bindValue(2, '9 7220-8368');
// $stmt->bindValue(3, 1);
// $stmt->execute();



$stmt = $conn->query("SELECT * FROM phones;", PDO::FETCH_ASSOC);
$stmt->execute();



var_dump($stmt->fetchAll());

// $sql = "DELETE FROM phones WHERE id > 0;";
// $stmt = $conn->prepare($sql);
// $stmt->execute();