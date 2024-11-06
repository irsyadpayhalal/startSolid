<?php

namespace App\Concrete;

use App\Contracts\IDatabaseConnection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;

class DbalConnector implements IDatabaseConnection
{
    /** @var Connection $connection */
    private Connection $connection;

    /**
     * @param string $host The database host.
     * @param string $username The database username.
     * @param string $password The database password.
     * @param string $database The database name.
     */
    public function __construct(
        string $host,
        string $username,
        string $password,
        string $database
    ) {
        $connectionParams = [
            "dbname" => $database,
            "user" => $username,
            "password" => $password,
            "host" => $host,
            "driver" => "pdo_mysql",
        ];

        try {
            $this->connection = DriverManager::getConnection($connectionParams);
        } catch (Exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get the DBAL Connection instance.
     *
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * Create a new QueryBuilder instance.
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }
}
