<?php $__env->startSection('content'); ?>
    <style>
        .all-products-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .all-products-grid .product-card {
            padding: 12px;
            gap: 10px;
        }

        .all-products-grid .thumb {
            height: 185px;
            border-radius: 12px;
        }

        .all-products-grid .product-card h3 {
            font-size: 16px;
            line-height: 1.35;
        }

        .all-products-grid .product-card .price {
            font-size: 18px;
        }

        .all-products-grid .product-card .btn {
            min-height: 42px;
            padding: 0 14px;
        }

        .products-search-panel {
            display: grid;
            gap: 12px;
            width: min(100%, 520px);
        }

        .products-search-input {
            width: 100%;
            min-height: 48px;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 0 16px;
            color: var(--ink);
            background: #fff;
        }

        .products-search-status {
            min-height: 20px;
        }

        @media (max-width: 1400px) {
            .all-products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .all-products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 820px) {
            .all-products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .all-products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="page-section card" style="padding:20px;">
        <div style="display:flex; justify-content:space-between; gap:16px; align-items:end; flex-wrap:wrap; margin-bottom:18px;">
            <div>
                <h1 class="section-title" style="margin-bottom:8px;">Tất cả sản phẩm</h1>
                <p class="meta">Xem toàn bộ source code hiện có trong cửa hàng và tìm sản phẩm ngay tại trang này.</p>
            </div>

            <div class="products-search-panel">
                <input
                    id="products-live-search"
                    class="products-search-input"
                    type="text"
                    name="keyword"
                    value="<?php echo e($keyword); ?>"
                    placeholder="Nhập tên sản phẩm, mô tả hoặc danh mục..."
                    autocomplete="off"
                >
                <div id="products-search-status" class="meta products-search-status">
                    <?php if($isSearching): ?>
                        Tim thay <?php echo e($products->count()); ?> san pham cho "<?php echo e($keyword); ?>".
                    <?php else: ?>
                        
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div
            id="products-grid"
            class="product-grid all-products-grid"
            style="margin-top:20px;"
            data-search-url="<?php echo e(route('user.products.live_search')); ?>"
        >
            <?php echo $__env->make('user.product._cards', ['products' => $products], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div id="products-pagination" style="margin-top:20px; <?php echo e($isSearching ? 'display:none;' : ''); ?>">
            <?php if(! $isSearching && method_exists($products, 'links')): ?>
                <?php echo e($products->links()); ?>

            <?php endif; ?>
        </div>
    </section>

    <script>
        (() => {
            const input = document.getElementById('products-live-search');
            const grid = document.getElementById('products-grid');
            const status = document.getElementById('products-search-status');
            const pagination = document.getElementById('products-pagination');

            if (!input || !grid || !status || !pagination) {
                return;
            }

            let timer = null;
            let controller = null;

            const runSearch = () => {
                const keyword = input.value.trim();
                const url = new URL(grid.dataset.searchUrl, window.location.origin);
                url.searchParams.set('keyword', keyword);

                if (controller) {
                    controller.abort();
                }

                controller = new AbortController();
                status.textContent = keyword ? 'Đang tìm kiếm...' : 'Đang tải lại danh sách sản phẩm...';

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    signal: controller.signal,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        grid.innerHTML = data.html;
                        pagination.style.display = keyword ? 'none' : '';

                        if (keyword) {
                            status.textContent = `Tim thay ${data.count} san pham cho "${keyword}".`;
                            window.history.replaceState({}, '', `<?php echo e(route('user.products')); ?>?keyword=${encodeURIComponent(keyword)}`);
                        } else {
                            status.textContent = '';
                            window.history.replaceState({}, '', `<?php echo e(route('user.products')); ?>`);
                        }
                    })
                    .catch((error) => {
                        if (error.name !== 'AbortError') {
                            status.textContent = 'Không thể tải kết quả tìm kiếm lúc này.';
                        }
                    });
            };

            input.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(runSearch, 250);
            });
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/user/product/index.blade.php ENDPATH**/ ?>