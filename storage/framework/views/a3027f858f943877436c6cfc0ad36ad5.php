<?php $__env->startSection('content'); ?>
    <div class="page-head">
        <div>
            <h1>Liên hệ</h1>
            <p>Tổng hợp các tin nhắn gửi từ người dùng để xử lý nhanh.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta"><?php echo e($contacts->count()); ?> liên hệ</span>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Hộp thư đến</h3>
            <span class="table-chip">Inbox</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Nội dung</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="cell-title"><?php echo e($contact->name); ?></div>
                        </td>
                        <td class="muted"><?php echo e($contact->email); ?></td>
                        <td><?php echo e($contact->message); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="muted">Chưa có liên hệ nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/admin/contacts/index.blade.php ENDPATH**/ ?>