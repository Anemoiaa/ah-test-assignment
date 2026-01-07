<?php

namespace Anemoiaa\AhTestAssignment\repositories;

use Anemoiaa\AhTestAssignment\core\Database;
use InvalidArgumentException;
use PDO;

abstract class BaseRepository
{
    protected string $table;
    protected array $fillable = [];

    protected function pdo(): PDO
    {
        return Database::connection();
    }

    public function create(array $data): array
    {
        $filtered = array_intersect_key(
            $data,
            array_flip($this->fillable)
        );

        if (empty($filtered)) {
            throw new InvalidArgumentException('No data provided to create');
        }

        $columns = implode(', ', array_keys($filtered));
        $placeholders = implode(', ', array_map(fn ($k) => ":$k", array_keys($filtered)));

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            $columns,
            $placeholders
        );

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($filtered);

        $id = (int) $this->pdo()->lastInsertId();

        return $this->find($id);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo()->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
