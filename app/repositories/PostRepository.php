<?php

namespace Anemoiaa\AhTestAssignment\repositories;

use PDO;

class PostRepository extends BaseRepository
{
    public const SORT_OPTIONS = [
        'views_asc'  => ['field' => 'views',       'direction' => 'ASC',  'label' => 'Views: Low → High'],
        'views_desc' => ['field' => 'views',       'direction' => 'DESC', 'label' => 'Views: High → Low'],
        'oldest'     => ['field' => 'created_at',  'direction' => 'ASC',  'label' => 'Oldest First'],
        'newest'     => ['field' => 'created_at',  'direction' => 'DESC', 'label' => 'Newest First'],
    ];

    protected string $table = 'posts';
    protected array $fillable = [
        'title',
        'description',
        'text',
        'image',
        'views',
        'created_at',
        'updated_at',
    ];

    public function getPostsByCategory(
        int $categoryId,
        string $sort = 'newest',
        int $page = 1,
        int $perPage = 10
    ): array {
        $orderBy = self::SORT_OPTIONS[$sort] ?? self::SORT_OPTIONS['newest'];
        $sqlOrder = $orderBy['field'] . ' ' . $orderBy['direction'];

        $offset = ($page - 1) * $perPage;

        $total = $this->getPostsCountByCategory($categoryId);

        $stmt = $this->pdo()->prepare("
            SELECT p.*
            FROM posts p
            JOIN post_category pc ON p.id = pc.post_id
            WHERE pc.category_id = :categoryId
            ORDER BY $sqlOrder
            LIMIT :limit 
            OFFSET :offset
        ");

        $stmt->bindValue('categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data'  => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
        ];
    }

    public function getSimilarPosts(int $postId, int $limit = 3): array
    {
        $stmt = $this->pdo()->prepare(
            'SELECT p.* 
             FROM posts p
             JOIN post_category pc ON pc.post_id = p.id
             WHERE pc.category_id IN (
                 SELECT category_id FROM post_category WHERE post_id = :postId
             )
             AND p.id != :postId
             GROUP BY p.id
             ORDER BY p.created_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue('postId', $postId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostsCountByCategory(int $categoryId): int
    {
        $stmtCount = $this->pdo()->prepare(
            'SELECT COUNT(*) FROM post_category WHERE category_id = :categoryId'
        );
        $stmtCount->execute(['categoryId' => $categoryId]);

        return (int) $stmtCount->fetchColumn();
    }

    public function incrementViews(int $postId, int $step = 1): void
    {
        $stmt = $this->pdo()->prepare(
            'UPDATE posts SET views = views + :step WHERE id = :postId'
        );

        $stmt->bindValue('postId', $postId, PDO::PARAM_INT);
        $stmt->bindValue('step', $step, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function attachCategories(int $postId, array $categoryIds): void
    {
        $stmt = $this->pdo()->prepare(
            'INSERT INTO post_category (post_id, category_id) VALUES (:post, :category)'
        );

        foreach ($categoryIds as $categoryId) {
            $stmt->execute([
                'post'     => $postId,
                'category' => $categoryId,
            ]);
        }
    }
}
