<?php
namespace App\Models;

use Db\Database;

class Product {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getByCategory(?int $categoryId, string $sort): array {
        $orderBy = match($sort) {
            'price_asc' => 'price ASC',
            'alpha' => 'name ASC',
            'new' => 'created_at DESC',
            default => 'price ASC'
        };

        $params = [];
        $where = '';
        if ($categoryId !== null && $categoryId !== -1) {
            $where = 'WHERE category_id = ?';
            $params[] = $categoryId;
        }

        $sql = "SELECT * FROM products $where ORDER BY $orderBy";
        return $this->db->query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
