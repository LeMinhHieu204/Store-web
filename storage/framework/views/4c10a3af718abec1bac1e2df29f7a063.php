<?php $__env->startSection('content'); ?>
    <div class="dashboard-shell">
        <div class="dashboard-hero">
            <section class="hero-panel">
                <div class="hero-eyebrow">Commerce Overview</div>
                <h1 class="hero-title">Bảng điều hành bán hàng</h1>
                <p class="hero-copy">Theo dõi tăng trưởng cửa hàng, đơn hàng, doanh thu và nhịp độ vận hành từ một màn hình trung tâm. Ưu tiên thiết kế để đọc nhanh và ra quyết định nhanh.</p>

                <div class="hero-strip">
                    <div class="hero-chip">
                        <strong><?php echo e($totalOrders); ?></strong>
                        <span>Tổng đơn hàng</span>
                    </div>
                    <div class="hero-chip">
                        <strong><?php echo e($completedOrdersCount); ?></strong>
                        <span>Đơn hoàn tất</span>
                    </div>
                    <div class="hero-chip">
                        <strong><?php echo e($featuredProductsCount); ?></strong>
                        <span>Sản phẩm nổi bật</span>
                    </div>
                </div>
            </section>

            <aside class="side-panel">
                <h3>Chỉ số vận hành</h3>
                <p>Các chỉ số cần nhìn ngay khi vào hệ thống quản trị.</p>

                <div class="metric-stack">
                    <div class="metric-row">
                        <div>
                            <div class="muted">Doanh thu hoàn tất</div>
                            <strong><?php echo e(number_format($totalRevenue)); ?> đ</strong>
                        </div>
                        <span class="status-badge green">Đã chốt</span>
                    </div>

                    <div class="metric-row">
                        <div>
                            <div class="muted">Giá trị đơn trung bình</div>
                            <strong><?php echo e(number_format($averageOrderValue)); ?> đ</strong>
                        </div>
                        <span class="status-badge amber">AOV</span>
                    </div>

                    <div class="metric-row">
                        <div>
                            <div class="muted">Đơn chưa hoàn tất</div>
                            <strong><?php echo e($pendingOrdersCount); ?></strong>
                        </div>
                        <span class="status-badge amber">Theo dõi</span>
                    </div>
                </div>
            </aside>
        </div>

        <div class="cards">
            <div class="card stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-kicker">Người dùng</div>
                        <div class="stat-value"><?php echo e($totalUsers); ?></div>
                    </div>
                    <div class="stat-icon blue">U</div>
                </div>
                <div class="muted">Tổng số tài khoản đã tạo trong hệ thống.</div>
            </div>

            <div class="card stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-kicker">Sản phẩm</div>
                        <div class="stat-value"><?php echo e($totalProducts); ?></div>
                    </div>
                    <div class="stat-icon violet">P</div>
                </div>
                <div class="muted">Danh mục source code đang được bày bán.</div>
            </div>

            <div class="card stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-kicker">Đơn mới</div>
                        <div class="stat-value"><?php echo e($latestOrders->count()); ?></div>
                    </div>
                    <div class="stat-icon amber">O</div>
                </div>
                <div class="muted">Lượng đơn vừa phát sinh gần đây để cần kiểm tra nhanh.</div>
            </div>

            <div class="card stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-kicker">Khách mới</div>
                        <div class="stat-value"><?php echo e($recentUsers->count()); ?></div>
                    </div>
                    <div class="stat-icon green">N</div>
                </div>
                <div class="muted">Số khách hàng mới thêm gần đây trong hệ thống.</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="table-wrap">
                <div class="table-head">
                    <h3>Đơn hàng gần đây</h3>
                    <span class="table-chip"><?php echo e($latestOrders->count()); ?> đơn gần nhất</span>
                </div>

                <div class="list-stack">
                    <?php $__empty_1 = true; $__currentLoopData = $latestOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="activity-item">
                            <div>
                                <span class="title">Đơn #<?php echo e($order->id); ?></span>
                                <div class="activity-meta"><?php echo e($order->user->name); ?></div>
                            </div>
                            <div style="text-align:right;">
                                <strong><?php echo e(number_format($order->total_price)); ?> đ</strong>
                                <div class="activity-meta"><?php echo e(ucfirst($order->status)); ?></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="activity-item">
                            <div class="activity-meta">Chưa có đơn hàng để hiển thị.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="list-stack">
                <div class="table-wrap">
                    <div class="table-head">
                        <h3>Khách hàng mới</h3>
                        <span class="table-chip"><?php echo e($recentUsers->count()); ?> tài khoản</span>
                    </div>

                    <div class="list-stack">
                        <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="activity-item">
                                <div>
                                    <span class="title"><?php echo e($user->name); ?></span>
                                    <div class="activity-meta"><?php echo e($user->email); ?></div>
                                </div>
                                <div class="activity-meta"><?php echo e(strtoupper($user->role)); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="activity-item">
                                <div class="activity-meta">Chưa có người dùng mới.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-wrap">
                    <div class="table-head">
                        <h3>Sản phẩm bán tốt</h3>
                        <span class="table-chip">Top 5</span>
                    </div>

                    <div class="list-stack">
                        <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="activity-item">
                                <div>
                                    <span class="title"><?php echo e($item->product?->title ?? 'Sản phẩm đã xóa'); ?></span>
                                    <div class="activity-meta">Product ID: <?php echo e($item->product_id); ?></div>
                                </div>
                                <strong><?php echo e($item->total_sales); ?> lượt</strong>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="activity-item">
                                <div class="activity-meta">Chưa có dữ liệu bán hàng.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>