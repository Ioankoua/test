document.addEventListener('DOMContentLoaded', () => {
    const categoryList = document.getElementById('category-list');
    const sortSelect = document.getElementById('sort');
    const productList = document.getElementById('product-list');

    let currentCategory = -1; // -1 = все
    let currentSort = 'price_asc';

    function loadProducts() {
        const url = `ajax.php?category_id=${currentCategory}&sort=${currentSort}`;
        fetch(url)
            .then(res => res.json())
            .then(products => {
                productList.innerHTML = '';

                if (products.length === 0) {
                    productList.innerHTML = '<p>Товары не найдены.</p>';
                    return;
                }

                products.forEach(p => {
                    productList.innerHTML += `
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${p.name}</h5>
                                <p class="card-text">${p.price} грн</p>
                                <button class="btn btn-primary buy-btn" data-name="${p.name}">Купить</button>
                            </div>
                        </div>
                    </div>`;
                });

                // Кнопка "Купить"
                document.querySelectorAll('.buy-btn').forEach(btn => {
                    btn.addEventListener('click', e => {
                        const name = e.target.dataset.name;
                        const modalBody = document.getElementById('modal-body');
                        modalBody.textContent = name;
                        new bootstrap.Modal(document.getElementById('productModal')).show();
                    });
                });

                // Обновляем URL
                const params = new URLSearchParams();
                if (currentCategory !== -1) params.set('category_id', currentCategory);
                params.set('sort', currentSort);
                history.pushState(null, '', '?' + params.toString());

                // Подсветка категории
                document.querySelectorAll('.category-item').forEach(el => {
                    el.classList.toggle('active', el.dataset.id == currentCategory);
                });

                // Сортировка
                sortSelect.value = currentSort;
            })
            .catch(() => {
                productList.innerHTML = '<p>Ошибка при загрузке товаров.</p>';
            });
    }

    // Событие клика по категориям
    categoryList.addEventListener('click', e => {
        if (e.target.classList.contains('category-item')) {
            currentCategory = parseInt(e.target.dataset.id);
            loadProducts();
        }
    });

    // Смена сортировки
    sortSelect.addEventListener('change', e => {
        currentSort = e.target.value;
        loadProducts();
    });

    // При загрузке читаем параметры из URL
    const params = new URLSearchParams(window.location.search);
    currentCategory = params.has('category_id') ? parseInt(params.get('category_id')) : -1;
    currentSort = params.get('sort') || 'price_asc';

    // Подсветка категории
    document.querySelectorAll('.category-item').forEach(el => {
        el.classList.toggle('active', el.dataset.id == currentCategory);
    });

    // Устанавливаем селект
    sortSelect.value = currentSort;

    // Загружаем товары
    loadProducts();
});
