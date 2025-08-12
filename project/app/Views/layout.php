<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Каталог товаров</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        #category-list .category-item:hover,
        #sort:hover {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container-fluid mt-3">
    <div class="row">
        <!-- Категории слева -->
        <aside class="col-3">
            <h4>Категории</h4>
            <ul id="category-list" class="list-group">
                <li class="list-group-item category-item <?= $categoryId === -1 ? 'active' : '' ?>" data-id="-1">
                    Все (<?= array_sum(array_column($categories, 'product_count')) ?>)
                </li>
                <?php foreach ($categories as $cat): ?>
                    <li class="list-group-item category-item <?= $categoryId === (int)$cat['id'] ? 'active' : '' ?>" data-id="<?= (int)$cat['id'] ?>">
                        <?= htmlspecialchars($cat['name']) ?> (<?= (int)$cat['product_count'] ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <main class="col-9">
            <div class="mb-3">
                <label for="sort" class="form-label">Сортировка:</label>
                <select id="sort" class="form-select">
                    <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Сначала дешёвые</option>
                    <option value="alpha" <?= $sort === 'alpha' ? 'selected' : '' ?>>По алфавиту</option>
                    <option value="new" <?= $sort === 'new' ? 'selected' : '' ?>>Сначала новые</option>
                </select>
            </div>
            <div id="product-list" class="row">
            </div>
        </main>
    </div>
</div>

<!-- Модалка Bootstrap -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Товар</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body" id="modal-body">Загрузка...</div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
