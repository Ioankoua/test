<?php

$host = '127.0.0.1';
$port = 3306;      
$dbname = 'test2';  
$user = 'root';    
$pass = 'root';     

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе: " . $e->getMessage());
}

// Получаем все категории
$stmt = $pdo->query("SELECT categories_id, parent_id FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Группируем категории по parent_id для быстрого доступа к детям
$grouped = [];
foreach ($categories as $cat) {
    $grouped[$cat['parent_id']][] = $cat['categories_id'];
}

// Рекурсивная функция для построения дерева
function buildTree(array $grouped, int $parentId = 0): array {
    $tree = [];
    if (isset($grouped[$parentId])) {
        foreach ($grouped[$parentId] as $catId) {
            if (isset($grouped[$catId])) {
                $tree[$catId] = buildTree($grouped, $catId);
            } else {
                $tree[$catId] = $catId;
            }
        }
    }
    return $tree;
}

$tree = buildTree($grouped);

// Функция для рендеринга дерева в HTML с интерактивным сворачиванием
function renderTree(array $tree): string {
    $html = '<ul style="list-style:none; padding-left:20px;">';
    foreach ($tree as $key => $value) {
        if (is_array($value)) {
            $html .= '<li><details><summary>' . htmlspecialchars($key) . '</summary>';
            $html .= renderTree($value);
            $html .= '</details></li>';
        } else {
            $html .= '<li>' . htmlspecialchars($value) . '</li>';
        }
    }
    $html .= '</ul>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Дерево категорий</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        ul {
            margin: 0;
            padding-left: 1em;
        }
        details summary {
            cursor: pointer;
            font-weight: bold;
            user-select: none;
        }
    </style>
</head>
<body>
<h1>Дерево категорий</h1>
<?php
echo renderTree($tree);
?>
</body>
</html>
