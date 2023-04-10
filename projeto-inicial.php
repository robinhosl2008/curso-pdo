<?php

use DateTimeImmutable;
use Alura\PDO\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Robson Lourenço',
    new DateTimeImmutable('1982-03-27')
);

echo $student->age();