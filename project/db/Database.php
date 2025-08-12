<?php
namespace Db;

use PDO;

class Database {
    private PDO $pdo;

    public function __construct() {
        $host = '127.0.0.1';
        $port = 3306;
        $dbname = 'project';
        $user = 'root';
        $pass = 'root';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query(string $sql, array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
