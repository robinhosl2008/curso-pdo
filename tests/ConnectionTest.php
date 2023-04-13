<?php

use Alura\PDO\Domain\Model\Student;
use Alura\PDO\Infrastructure\Repository\PdoStudentRepository;
use PHPUnit\Framework\TestCase;

require_once 'vendor/autoload.php';

class ConnectionTest extends TestCase
{
    private PDO $pdo;
    private array $result;
    private int $numberOfTables;
    private Student $student;
    private PdoStudentRepository $repository;

    public function setUp(): void
    {
        // Criate a database into memory.
        $this->pdo = new PDO('sqlite::memory:');

        // Criate a new table into database.
        $this->pdo->exec("
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
    }

    public function testVerifingIfConnectionWithDatabaseHasCreated(): void
    {
        self::assertEquals('object', gettype($this->pdo));
    }

    public function testVerifyIfTheTableHasCreated(): void
    {
        $sql = "SELECT COUNT() FROM sqlite_master WHERE type = 'table' AND name = 'students';";
        $pdoQuery = $this->pdo->query($sql);
        $this->numberOfTables = $pdoQuery->fetchAll()[0][0];

        self::assertEquals(1, $this->numberOfTables);
    }

    public function testVerifingIfStudentsTableHasData(): void
    {
        $birthDate = new DateTimeImmutable('1982-03-27');
        $this->student = new Student(null, 'Teste', $birthDate);
        
        $this->repository = new PdoStudentRepository($this->pdo);
        $this->repository->insert($this->student);
        $this->result = $this->repository->allStudents();
        
        self::assertCount(1, $this->result);
        self::assertEquals("Teste", $this->result[0]->name());
        self::assertEquals("1982-03-27", $this->result[0]->birthDate()->format('Y-m-d'));
    }

    public function tearDown(): void
    {
        // Delete table from database.
        $this->pdo->exec("
            DROP TABLE students;
        ");
    }
}