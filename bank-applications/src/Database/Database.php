<?php


namespace BankApplication\Database;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        try {
            $this->connection = new PDO(
                $dsn,
                $config['user'],
                $config['pass'],
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(array $config)
    {
        if (!self::$instance) {
            self::$instance = new Database($config);
        }
        return self::$instance->connection;
    }
}