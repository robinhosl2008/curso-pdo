<?php

use Alura\PDO\Model\Student;
use PHPUnit\Framework\TestCase;

require_once 'vendor/autoload.php';

class ConnectionTest extends TestCase
{
    private PDO $pdo;
    private array $result;
    private int $numberOfTables;

    public function setUp(): void
    {
        // Criate a database into memory.
        $this->pdo = new PDO('sqlite::memory:');

        // Criate a new table into database.
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS students (
            id INTEGER PRIMARY KEY,
            name TEXT,
            birthDate TEXT);
        ");

        $sql = "SELECT COUNT() FROM sqlite_master WHERE type = 'table' AND name = 'students';";
        $pdoQuery = $this->pdo->query($sql);
        $this->numberOfTables = $pdoQuery->fetchAll()[0][0];

        // Adding registry in the table.
        $birthDate = new DateTimeImmutable('1982-03-27');
        $student = new Student(null, 'Robson Lourenço', $birthDate);
        $sql = "INSERT INTO students (name, birthDate) VALUES ('{$student->name()}', '{$student->birthDay()->format('Y-m-d')}')";
        $this->pdo->exec($sql);

    }

    public function testVerifingIfConnectionWithDatabaseHasCreated(): void
    {
        self::assertEquals('object', gettype($this->pdo));
    }

    public function testVerifyIfTheTableHasCreated(): void
    {
        self::assertEquals(1, $this->numberOfTables);
    }

    public function testVerifingIfStudentsTableHasData(): void
    {
        $sql = "SELECT * FROM students";
        $pdoQuery = $this->pdo->query($sql);
        $this->result = $pdoQuery->fetchAll(PDO::FETCH_ASSOC);
        
        self::assertCount(1, $this->result);
        self::assertEquals("Robson Lourenço", $this->result[0]['name']);
        self::assertEquals("1982-03-27", $this->result[0]['birthDate']);
    }

    public function tearDown(): void
    {
        // Delete table from database.
        $this->pdo->exec("
            DROP TABLE students;
        ");
    }
}