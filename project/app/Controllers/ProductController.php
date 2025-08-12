<?php
namespace App\Controllers;

use Db\Database;
use App\Models\Category;
use App\Models\Product;

class ProductController {
    private Database $db;
    private Category $categoryModel;
    private Product $productModel;

    public function __construct() {
        $this->db = new Database();
        $this->categoryModel = new Category($this->db);
        $this->productModel = new Product($this->db);
    }

    public function index(): void {

        $categories = $this->categoryModel->getAllWithCount();

        $categoryId = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? (int)$_GET['category_id'] : -1;
        $sort = $_GET['sort'] ?? 'price_asc';

        require __DIR__ . '/../Views/layout.php';
    }

    public function ajax(): void {
        $categoryId = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? (int)$_GET['category_id'] : -1;
        $sort = $_GET['sort'] ?? 'price_asc';

        $products = $this->productModel->getByCategory($categoryId, $sort);

        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }
}
