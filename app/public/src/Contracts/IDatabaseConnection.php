<?php

namespace App\Contracts;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

interface IDatabaseConnection
{
    /**
     * Responsible for fetching the database connection using Doctrine DBAL.
     *
     * @return Connection The Doctrine DBAL connection.
     */
    public function getConnection(): Connection;

    /**
     * Create a new QueryBuilder instance.
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder;
}
