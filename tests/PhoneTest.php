<?php

use Alura\PDO\Domain\Model\Phone;
use PHPUnit\Framework\TestCase;

final class PhoneTest extends TestCase
{
    private PDO $pdo;

    public function setUp(): void
    {
        // Criate a database into memory.
        $this->pdo = new PDO('sqlite::memory:');

        // Criate a new table into database.
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS phones (
                id INTEGER PRIMARY KEY,
                area_code TEXT,
                number TEXT,
                student_id INTEGER,
                FOREIGN KEY(student_id) REFERENCES students(id)
            );
        ");
    }

    public function testVerificaSETabelaFoiCriadaNoBancoDeDados()
    {
        $pdoQuery = $this->pdo->query(
            "SELECT COUNT() FROM sqlite_master WHERE type = 'table' AND name = 'phones';", 
            PDO::FETCH_ASSOC
        );

        $numberOfTables = $pdoQuery->fetchAll()[0]['COUNT()'];
        
        self::assertEquals(1, $numberOfTables);
    }

    public function testVerificaSeTelefonePodeSerAdicionado()
    {
        $statement = $this->pdo->prepare("INSERT INTO phones (area_code, number, student_id) VALUES (?, ?, ?);");
        $statement->execute([
            '21',
            '972208367',
            1
        ]);

        $pdoSql = $this->pdo->query("SELECT * FROM phones;", PDO::FETCH_ASSOC);
        $phones = $pdoSql->fetchAll();

        self::assertCount(1, $phones);
        self::assertEquals('integer', gettype($phones[0]['student_id']));
        self::assertEquals(1, $phones[0]['student_id']);
        self::assertEquals('string', gettype($phones[0]['area_code']));
        self::assertEquals(21, $phones[0]['area_code']);
        self::assertEquals('string', gettype($phones[0]['number']));
        self::assertEquals('972208367', $phones[0]['number']);
    }

    public function testVerificaSeRetornaTelefoneFormatado(): void
    {
        $phone = new Phone(null, '21', '9 7220-8367');

        self::assertEquals('(21) 9 7220-8367', $phone);
    }

    public function tearDown(): void
    {
        $this->pdo->exec("
            DROP TABLE phones;
        ");
    }
}