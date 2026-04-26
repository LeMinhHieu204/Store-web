<?php $__env->startSection('content'); ?>
    <div class="page-head">
        <div>
            <h1>Đơn hàng</h1>
            <p>Theo dõi nhanh khách hàng, sản phẩm và tổng tiền từng đơn.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta"><?php echo e($orders->count()); ?> đơn hiển thị</span>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sách đơn hàng</h3>
            <span class="table-chip">Cập nhật gần đây</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Đơn</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="cell-title">#<?php echo e($order->id); ?></div>
                        </td>
                        <td><?php echo e($order->user->name); ?></td>
                        <td>
                            <div class="muted">
                                <?php echo e($order->items->count()); ?> sản phẩm
                                <?php if($order->items->isNotEmpty()): ?>
                                    - <?php echo e($order->items->first()->product->title); ?>

                                    <?php if($order->items->count() > 1): ?>
                                        và <?php echo e($order->items->count() - 1); ?> mục khác
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <strong><?php echo e(number_format($order->total_price)); ?> đ</strong>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="muted">Chưa có đơn hàng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>