<?php

namespace Alura\PDO\Infrastructure\Persistence;
use PDO;

require_once 'vendor/autoload.php';

class ConnectionFactory
{
    private PDO $connection;

    public function __construct()
    {
        $pathDatabase = __DIR__ . '/../../../database.sqlite';
        $this->connection = new PDO("sqlite:{$pathDatabase}");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Return connection.
     *
     * @return PDO
     **/
    public function getPdo(): PDO
    {
        return $this->connection;
    }
}