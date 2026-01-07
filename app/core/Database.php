<?php

namespace Anemoiaa\AhTestAssignment\core;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
        $port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306;
        $db   = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE');
        $user = $_ENV['DB_USER'] ?? getenv('DB_USERNAME');
        $pass = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');

        if (!$host || !$db || !$user) {
            throw new RuntimeException('Database environment variables are not set');
        }

        $dsn = "mysql:host={$host};port={$port};dbname={$db};";

        try {
            $this->connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection error: ' . $e->getMessage());
        }
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new RuntimeException('Cannot unserialize singleton');
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function connection(): PDO
    {
        return self::getInstance()->connection;
    }
}