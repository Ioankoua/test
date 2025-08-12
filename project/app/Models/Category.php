<?php
namespace App\Models;

use Db\Database;

class Category {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAllWithCount(): array {
        $sql = "SELECT c.id, c.name, COUNT(p.id) AS product_count
                FROM categories c
                LEFT JOIN products p ON c.id = p.category_id
                GROUP BY c.id";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
