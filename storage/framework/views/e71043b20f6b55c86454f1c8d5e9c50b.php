<?php $__env->startSection('content'); ?>
    <div class="page-head">
        <div>
            <h1>Người dùng</h1>
            <p>Theo dõi tài khoản, email và vai trò trong hệ thống.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta"><?php echo e($users->count()); ?> tài khoản</span>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sách người dùng</h3>
            <span class="table-chip">Accounts</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="cell-title"><?php echo e($user->name); ?></div>
                        </td>
                        <td class="muted"><?php echo e($user->email); ?></td>
                        <td>
                            <?php if($user->role === 'admin'): ?>
                                <span class="status-badge green">Quản trị</span>
                            <?php else: ?>
                                <span class="status-badge amber">Người dùng</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="muted">Chưa có tài khoản nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/admin/users/index.blade.php ENDPATH**/ ?>