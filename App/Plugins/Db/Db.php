<?php

namespace App\Plugins\Db;

use PDO;
use PDOException;
use PDOStatement;

class Db implements IDb {
    /** @var PDO|null */
    private $connection = null;
    /** @var PDOStatement */
    private $stmt;

    /**
     * Constructor of this class
     * @param string $dsn
     * @param string $username
     * @param string $password
     */
    public function __construct(string $dsn, string $username, string $password) {
        $this->connection = $this->connect($dsn, $username, $password);
    }

    /**
     * Function to start a transaction
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    /**
     * Function to roll back the transaction
     */
    public function rollBack() {
        return $this->connection->rollBack();
    }

    /**
     * Function to commit a transaction
     */
    public function commit() {
        return $this->connection->commit();
    }

    /**
     * @param string $query
     * @param array $bind
     * @return bool
     */
    public function executeQuery(string $query, array $bind = []): bool {
        $this->stmt = $this->connection->prepare($query);
        if ($bind) {
            return $this->stmt->execute($bind);
        }
        return $this->stmt->execute();
    }

    /**
     * Function to get last inserted id
     * @param mixed $name
     * @return int
     */
    public function getLastInsertedId($name = null): int {
        $id = $this->connection->lastInsertId($name);
        return ($id ?: false);
    }

    /**
     * Function to get the connection
     * @return null|PDO
     */
    public function getConnection(): ?PDO {
        return $this->connection;
    }

    /**
     * Function to connect the db.
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @return PDO
     * @throws PDOException
     */
    private function connect(string $dsn, string $username, string $password) {
        try {
            return new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            // Just throw it:
            throw $e;
        }
    }

    /**
     * Function to return the last executed statement if any
     * @return null|PDOStatement
     */
    public function getStatement(): ?PDOStatement {
        return $this->stmt;
    }
}
