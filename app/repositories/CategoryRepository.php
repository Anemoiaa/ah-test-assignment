<?php

namespace Anemoiaa\AhTestAssignment\repositories;

use PDO;

class CategoryRepository extends BaseRepository
{
    protected string $table = 'categories';

    protected array $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    public function withLastPosts(int $limit = 3): array
    {
        $sql = <<<SQL
                SELECT
                c.id   AS category_id,
                c.name AS category_name,
                x.post_id,
                x.title,
                x.description,
                x.image,
                x.views,
                x.created_at
                FROM categories c
                JOIN (
                    SELECT
                        pc.category_id,
                        p.id AS post_id,
                        p.title,
                        p.description,
                        p.image,
                        p.views,
                        p.created_at,
                        ROW_NUMBER() OVER (
                            PARTITION BY pc.category_id
                            ORDER BY p.created_at DESC
                            ) AS rn
                        FROM post_category pc
                        JOIN posts p ON p.id = pc.post_id
                ) x ON x.category_id = c.id
                WHERE x.rn <= :limit
                ORDER BY c.id, x.created_at DESC;
            SQL;

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([
            'limit' => $limit,
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWithPostsCount(int $id): ?array
    {
        $stmt = $this->pdo()->prepare('
            SELECT c.*, COUNT(pc.post_id) AS posts_count
            FROM categories c
            LEFT JOIN post_category pc ON pc.category_id = c.id
            WHERE c.id = :id
            GROUP BY c.id
        ');

        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
